from enum import Enum
from collections import namedtuple
from itertools import islice, count, product, chain, repeat, accumulate, starmap
from functools import partial, lru_cache
from time import sleep
import operator as op

memoize = partial(lru_cache, maxsize=None)


class CellStates(Enum):
    Dead = 'Dead'
    Live = 'Live'

    def __str__(self):
        if self is CellStates.Dead: return '.'
        if self is CellStates.Live: return 'O'
        raise TypeError('Not a CellState: {!r}'.format(self))


_Position = namedtuple('Position', ('x', 'y'))
class Position(_Position):
    def __add__(l, r):
        return Pos(l.x + r.x, l.y + r.y)

    def __sub__(l, r):
        return Pos(l.x - r.x, l.y - r.y)

    def __mul__(l, r):
        return Pos(l.x * r.x, l.y * r.y)

    def __mod__(self, bounds):
        if self.x >= 0 and self.x < bounds.x and self.y >= 0 and self.y < bounds.y: return self
        return Pos(self.x % bounds.x, self.y % bounds.y)


# Position factory protocol
@memoize()
def Pos(*args, **kwargs):
    if args and not kwargs and isinstance(args[0], Position): return args[0]
    return Position(*args, **kwargs)


# Game Events
NeighborPopulation = namedtuple('NeighborPopulation', ('position'))
QueryCell = namedtuple('QueryCell', ('position'))
NextCellState = namedtuple('NextCellState', ('position', 'state'))
NextGameState = namedtuple('NextGameState', ())


# The eight cells adjacent to Position(0, 0)
NEIGHBOR_OFFSETS = tuple(Pos(*coords) for coords in product(range(-1, 2), repeat=2) if coords != (0, 0))


@memoize()
def neighbor_cache(bounds):
    'Returns a memoized function for looking up neighboring cell positions'
    return memoize()(lambda position: tuple(position + offset for offset in NEIGHBOR_OFFSETS))


class GameState:
    'A single frame of simulation state'
    def __init__(self, *, width, height, populate=()):
        self.bounds = Pos(width, height)
        self.position = memoize()(lambda position: position % self.bounds)
        self._positions = tuple(Pos(x, y) for y, x in product(range(height), range(width)))
        self._population = set(map(self.position, populate))

    @property
    def height(self):
        return self.bounds.y

    @property
    def width(self):
        return self.bounds.x

    def get_cell(self, Pos):
        Pos = self.position(Pos)
        return CellStates.Live if Pos in self._population else CellStates.Dead

    def set_cell(self, Pos, state):
        Pos = self.position(Pos)
        if state is CellStates.Live: self._population.add(Pos)
        elif state is CellStates.Dead: self._population.discard(Pos)
        else: raise TypeError('Not a CellState: {!r}'.format(state))
        return self

    def rows(self):
        cells = map(self.get_cell, self._positions)
        for _ in range(self.height):
            yield islice(cells, self.width)

    def new_blank(self):
        return self.__class__(width=self.width, height=self.height)

    def __str__(self):
        return "\n".join(''.join(map(str, row)) for row in self.rows())


# Simulation support
def advance_game_state(game_state, bus):
    neighbors_of = neighbor_cache(game_state.bounds)
    get_state = memoize()(lambda position: game_state.get_cell(position))
    next_state = game_state.new_blank()
    event = next(bus)
    while True:
        if isinstance(event, NeighborPopulation):
            states = [get_state(p) for p in neighbors_of(event.position)]
            event = bus.send(states.count(CellStates.Live))
        elif isinstance(event, QueryCell):
            event = bus.send(get_state(event.position))
        elif isinstance(event, NextCellState):
            if event.state == CellStates.Live:
                next_state.set_cell(event.position, event.state)
            event = next(bus)
        elif isinstance(event, NextGameState):
            return next_state
        else:
            raise Exception('Unknown game event {!r}'.format(event))


def game_event_bus(height, width):
    while True:
        for y, x in product(range(height), range(width)):
            yield from visit_cell(Pos(x, y))
        yield NextGameState()


def visit_cell(position):
    state = yield QueryCell(position)
    population = yield NeighborPopulation(position)
    next_state = next_cell_state(state, population)
    yield NextCellState(position=position, state=next_state)


def next_cell_state(state, population):
    if state is CellStates.Live and (population < 2 or population > 3): return CellStates.Dead
    if state is CellStates.Dead and population == 3: return CellStates.Live
    return state


def game_frames(game_state):
    bus = game_event_bus(game_state.height, game_state.width)
    yield game_state
    while True:
        game_state = advance_game_state(game_state, bus)
        yield game_state


# Patterns
def glider():
    'Basic glider pattern'
    return [
        Pos(1,0),
        Pos(2,1),
        Pos(0,2),
        Pos(1,2),
        Pos(2,2)
    ]


def glider_line(n):
    'A line of n gliders'
    seq = pattern_sequence(glider())
    seq = seq if n is None else islice(seq, n)
    return chain.from_iterable(seq)


def glider_mess():
    'Some gliders going in different directions'
    return chain(
        glider(),
        shift(invert(glider()), Pos(11, 11)),
        shift(mirror(glider()), Pos(17, 17))
    )


# Pattern transforms
def pattern_sequence(pattern, fn=None):
    'iterate over a cumulative transform of the given pattern'
    if fn is None:
        interval = Pos(1, 1) + pattern_bounds(pattern)
        fn = partial(shift, offset=interval)

    pattern = list(pattern)
    while True:
        yield pattern
        pattern = fn(pattern)


def pattern_bounds(pattern):
    'Dimensions of the given pattern'
    pattern = list(pattern)
    if len(pattern) == 0: return Pos(0, 0)
    xs = list(map(lambda p: p.x, pattern))
    ys = list(map(lambda p: p.y, pattern))
    return Pos(1 + max(xs) - min(xs), 1 + max(ys) - min(ys))


def shift(pattern, offset):
    'Move the pattern'
    return [p + offset for p in pattern]


def mirror(pattern):
    'Flip the pattern horizontally'
    return [p * Pos(-1, 1) for p in pattern]


def invert(pattern):
    'Flip the pattern vertically'
    return [p * Pos(1, -1) for p in pattern]


# Throw the switch!
def new_game_state():
    return GameState(width=60, height=30, populate=glider_mess())
    # return GameState(width=60, height=30, populate=glider_line(n=5))


def run():
    for game_state in game_frames(new_game_state()):
        print(game_state, end='\n\n')


if __name__ == "__main__": run()