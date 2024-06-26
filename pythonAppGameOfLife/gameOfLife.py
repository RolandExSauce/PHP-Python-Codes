""" Conways game of life """
#pylint: disable=E0611
from PyQt5.QtWidgets import QApplication, QPushButton, QWidget, QGridLayout
from PyQt5.QtWidgets import QMainWindow, QShortcut, QAction, qApp, QStyleFactory
from PyQt5.QtWidgets import QMessageBox
from PyQt5.QtGui import QKeySequence, QIcon
from PyQt5 import QtGui
import sys



class fieldsButton(QPushButton):
    def __init__(self, x, y, p, s):
        super().__init__()
        self._x = x
        self._y = y
        self._parent = p
        self.setFixedSize(s, s)
        self.clicked.connect(self._click)
        self.setStyleSheet("background-color: White")

    def _click(self):
        self._parent.click(self._x, self._y)


class myGame(QMainWindow):
    def __init__(self, dim=40, bSize=20, parent=None):
        super().__init__()
        self.dim = dim
        self.bSize = bSize
        self.cells = [[False for _ in range(self.dim)]
                        for _ in range(self.dim)

                        ]

        
        
        self.gen = 0
        self.setupUI()
        self.setupMenu()
        self.evolve()


    def setupUI(self):
        self.resize(self.bSize * (self.dim + 1), self.bSize * (self.dim + 1))
        
        self.centralwidget = QWidget()
        self.setCentralWidget(self.centralwidget)
        self.gridLayout = QGridLayout(self.centralwidget)
        self.gridLayout.setSpacing(0)
        #self.gridLayout.setContentsMargins(0,50,0,0)

        self.buttons = []
        for i in range(self.dim):
            l = []
            for j in range(self.dim):
                #print(self.dim)
                b = fieldsButton(i, j, self, self.bSize)
                l.append(b)
                self.gridLayout.addWidget(b, i, j)
                self.gridLayout.setColumnMinimumWidth(j, self.bSize)
            self.buttons.append(l)
            

    #Menu
    def setupMenu(self):
        self.shortcutSpace = QShortcut(QKeySequence('space'), self)
        self.shortcutSpace.activated.connect(self.on_spacebar)

        menubar = self.menuBar()
        startAction = QAction('Start', self)
        startAction.triggered.connect(self.evolve)
        menubar.addAction(startAction)

        pauseAction = QAction('Pause', self)
        #pauseAction.triggered.connect(self.load)
        menubar.addAction(pauseAction)
        
        
        clearAct = QAction('Reset', self)
        clearAct.triggered.connect(self._clear)
        menubar.addAction(clearAct)

        helpAct = QAction('Help', self)
        helpAct.triggered.connect(self.rulesPopUp)
        menubar.addAction(helpAct)

        exitAct = QAction('Exit', self)
        exitAct.triggered.connect(qApp.quit)
        menubar.addAction(exitAct)


    def rulesPopUp(self):
        message = QMessageBox.information(
            self, 'Rules of the Game',
            'Any live cell with fewer than two live neighbors dies, '+
            'as if by under population.\n'+
            'Any live cell with two or three live neighbors lives on '+
            'Any live cell with more than three live neighbors dies, '+
            'as if by overpopulation.\n'+
            'Any dead cell with exactly three live neighbors becomes '+
            'a live cell, as if by reproduction.'+
            '\n\nClick to toggle a cell between dead/alive.'
            '\nUse Spacebar to advance to next gen.',
            QMessageBox.Ok
            )


    def _clear(self):
        self.cells = [[False for _ in range(self.dim)]
                        for _ in range(self.dim)]
                            
        for b_row in self.buttons:
            for b in b_row:
                b.setStyleSheet("background-color: White")


    def on_spacebar(self):
        self.evolve()
        self.gen += 1
        self.setWindowTitle(f'Gen {self.gen}')



    def click(self, x=0, y=0):
        self.swap(x, y)

    def swap(self, x, y):
        self.cells[x][y] = not self.cells[x][y]
        self.buttons[x][y].setStyleSheet(
            f'background-color: {"black" if self.cells[x][y] else "white"}'
        )
        
        
        
    #envolving method
    def evolve(self):
        before = []
        for x in self.cells:

            
            
            before.append(x[:])
        c = 0
        while c < self.dim ** 2:
            x = c // self.dim
            y = c % self.dim
            alive_neighbors = 0
            for dx in range(-1, 2):
                if not -1 < x+dx < self.dim:
                    continue
                for dy in range(-1, 2):
                    if not -1 < y+dy < self.dim:
                        continue
                    if dy == dx == 0:
                        continue
                    alive_neighbors += before[x+dx][y+dy]

            if before[x][y]:
                if not 1 < alive_neighbors < 4:
                    self.swap(x, y)
            else:
                if alive_neighbors == 3:
                    self.swap(x, y)
            c += 1


def main():
    app = QApplication(sys.argv)
    window = myGame()
    window.setFixedSize(900, 880)
    window.setWindowTitle("Game of Life")
    window.setWindowIcon(QtGui.QIcon('./logoIcon.jpeg'))
    window.show()
    sys.exit(app.exec_())
    

# Standard boilerplate to call the main() function to begin
# the program.
if __name__ == '__main__':
    main()