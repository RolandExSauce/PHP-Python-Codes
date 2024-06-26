""" Conways game of life """
import sys
from PyQt5.QtGui import *
from PyQt5.QtCore import *
from PyQt5.QtWidgets import *

from PyQt5.QtWidgets import QApplication, QPushButton, QWidget, QGridLayout
from PyQt5.QtWidgets import QMainWindow, QShortcut, QAction, qApp, QStyleFactory
from PyQt5.QtWidgets import QMessageBox
from PyQt5.QtGui import QKeySequence, QIcon
from PyQt5 import QtGui, QtCore
from PyQt5 import QtCore, QtGui, QtWidgets
import random

#welcome window Class "myApp", designed with QT Designer 
#generated python Code using the following commmand line: python -m PyQt5.uic.pyuic -x [FILENAME].ui -o [FILENAME].py

#But simply to break it down: 
# We have our Class "myApp", then a constructor def __init__ which is called everytime an instance 
#of the class is created, then we have super().__init__() which is a convention to allow multiple inherintance in python

class myApp(QMainWindow):
    def __init__(self):
        super().__init__()
        self.InitUI()

    #setup the welcome window
    #binding icons, seting window size, Geometries, stylesheet, etc...
    def InitUI(self):
        self.setFixedSize(1090, 780)
        self.setWindowTitle("Game of Life")
        self.setWindowIcon(QtGui.QIcon('./my_pictures/logoIcon.jpeg'))

        switchToGameWindow_button = QPushButton(self)
        switchToGameWindow_button.move(100, 100)
        switchToGameWindow_button.clicked.connect(self.buttonWindow1_onClick)
        self.transferText = QLineEdit("Type here to switch to Game Window", self)

        self.centralwidget = QtWidgets.QWidget(self)
        self.centralwidget.setObjectName("centralwidget")
        self.label_5 = QtWidgets.QLabel(self.centralwidget)
        self.label_5.setGeometry(QtCore.QRect(410, 200, 491, 351))
        self.label_5.setText("")
        self.label_5.setPixmap(QtGui.QPixmap("my_pictures/gameOfLifeImage.png"))
        self.label_5.setObjectName("label_5")
        self.label = QtWidgets.QLabel(self.centralwidget)
        self.label.setGeometry(QtCore.QRect(-10, -20, 531, 431))
        self.label.setStyleSheet("label {\n"
"\n"
"background-color: rgb(255, 255, 255);\n"
"\n"
"}")
        self.label.setText("")
        self.label.setPixmap(QtGui.QPixmap("my_pictures/bg_white.jpg"))
        self.label.setObjectName("label")
        self.label_2 = QtWidgets.QLabel(self.centralwidget)
        self.label_2.setGeometry(QtCore.QRect(470, -10, 521, 431))
        self.label_2.setStyleSheet("label {\n"
"\n"
"background-color: rgb(255, 255, 255);\n"
"\n"
"}")
        self.label_2.setText("")
        self.label_2.setPixmap(QtGui.QPixmap("my_pictures/bg_white.jpg"))
        self.label_2.setObjectName("label_2")
        self.label_3 = QtWidgets.QLabel(self.centralwidget)
        self.label_3.setGeometry(QtCore.QRect(0, 350, 501, 451))
        self.label_3.setStyleSheet("label {\n"
"\n"
"background-color: rgb(255, 255, 255);\n"
"\n"
"}")
        self.label_3.setText("")
        self.label_3.setPixmap(QtGui.QPixmap("my_pictures/bg_white.jpg"))
        self.label_3.setObjectName("label_3")
        self.label_4 = QtWidgets.QLabel(self.centralwidget)
        self.label_4.setGeometry(QtCore.QRect(400, 420, 501, 441))
        self.label_4.setStyleSheet("label {\n"
"\n"
"background-color: rgb(255, 255, 255);\n"
"\n"
"}")
        self.label_4.setText("")
        self.label_4.setPixmap(QtGui.QPixmap("my_pictures/bg_white.jpg"))
        self.label_4.setObjectName("label_4")
        self.label_6 = QtWidgets.QLabel(self.centralwidget)
        self.label_6.setGeometry(QtCore.QRect(830, 380, 291, 431))
        self.label_6.setStyleSheet("label {\n"
"\n"
"background-color: rgb(255, 255, 255);\n"
"\n"
"}")
        self.label_6.setText("")
        self.label_6.setPixmap(QtGui.QPixmap("my_pictures/bg_white.jpg"))
        self.label_6.setObjectName("label_6")
        self.label_7 = QtWidgets.QLabel(self.centralwidget)
        self.label_7.setGeometry(QtCore.QRect(930, -10, 191, 431))
        self.label_7.setStyleSheet("label {\n"
"\n"
"background-color: rgb(255, 255, 255);\n"
"\n"
"}")
        self.label_7.setText("")
        self.label_7.setPixmap(QtGui.QPixmap("my_pictures/bg_white.jpg"))
        self.label_7.setObjectName("label_7")
        self.label_8 = QtWidgets.QLabel(self.centralwidget)
        self.label_8.setGeometry(QtCore.QRect(100, 130, 131, 151))
        self.label_8.setText("")
        self.label_8.setPixmap(QtGui.QPixmap("my_pictures/tgm_gebäude.png"))
        self.label_8.setObjectName("label_8")
        self.label_9 = QtWidgets.QLabel(self.centralwidget)
        self.label_9.setGeometry(QtCore.QRect(30, 30, 221, 71))
        self.label_9.setText("")
        self.label_9.setPixmap(QtGui.QPixmap("my_pictures/tgm_logo.png"))
        self.label_9.setObjectName("label_9")
        self.label_10 = QtWidgets.QLabel(self.centralwidget)
        self.label_10.setGeometry(QtCore.QRect(410, 20, 621, 131))
        self.label_10.setText("")
        self.label_10.setPixmap(QtGui.QPixmap("my_pictures/qt_design.jpg"))
        self.label_10.setObjectName("label_10")
        self.pushButton = QtWidgets.QPushButton(self.centralwidget)
        self.pushButton.setGeometry(QtCore.QRect(540, 630, 381, 101))
        self.pushButton.setStyleSheet("QPushButton {\n"
"font: 87 25pt \"Arial Black\";\n"
"\n"
"background-color: rgb(11, 117, 255);\n"
"border-radius:50px;\n"
"}\n"
"\n"
"QPushButton:hover \n"
"{\n"
"\n"
"border: 2px solid rgb(11, 117, 255);\n"
"\n"
"background-color: rgb(255, 255, 255);\n"
"\n"
"}")
        self.pushButton.setObjectName("pushButton")
        self.pushButton.clicked.connect(self.buttonWindow1_onClick)
        self.pushButton.setText("Let\'s play   ➜")
        self.label_12 = QtWidgets.QLabel(self.centralwidget)
        self.label_12.setGeometry(QtCore.QRect(70, 480, 271, 211))
        self.label_12.setText("")
        self.label_12.setPixmap(QtGui.QPixmap("my_pictures/orlando.png"))
        self.label_12.setObjectName("label_12")
        self.label_11 = QtWidgets.QLabel(self.centralwidget)
        self.label_11.setGeometry(QtCore.QRect(80, 710, 241, 31))
        self.label_11.setText("")
        self.label_11.setPixmap(QtGui.QPixmap("my_pictures/fullname.jpg"))
        self.label_11.setObjectName("label_11")
        self.label_13 = QtWidgets.QLabel(self.centralwidget)
        self.label_13.setGeometry(QtCore.QRect(100, 400, 171, 51))
        self.label_13.setText("")
        self.label_13.setPixmap(QtGui.QPixmap("my_pictures/creator.jpg"))
        self.label_13.setObjectName("label_13")
        self.label_7.raise_()
        self.label_6.raise_()
        self.label_4.raise_()
        self.label_3.raise_()
        self.label_2.raise_()
        self.label.raise_()
        self.label_5.raise_()
        self.label_8.raise_()
        self.label_9.raise_()
        self.label_10.raise_()
        self.pushButton.raise_()
        self.label_12.raise_()
        self.label_11.raise_()
        self.label_13.raise_()
        self.setCentralWidget(self.centralwidget)
        self.menubar = QtWidgets.QMenuBar(self)
        self.menubar.setGeometry(QtCore.QRect(0, 0, 1123, 21))
        self.menubar.setObjectName("menubar")
        self.setMenuBar(self.menubar)
        self.statusbar = QtWidgets.QStatusBar(self)
        self.statusbar.setObjectName("statusbar")
        self.setStatusBar(self.statusbar)
        self.show()
    
    #decorator which converts a simple python method to a Qt slot
    #it gets called when a signal connected to it is emitted, in this case the slot is bind
    # to a method buttonWindow1_onClick which calls the GameWindow Class, 
    # shows it and lastly closes the class "myApp"
    @pyqtSlot()
    def buttonWindow1_onClick(self):
        self.cams = GameWindow() 
        self.cams.show()
        self.close()
        
        
#for the buttons we create a fieldsButton Class and inherit QPushButton
class fieldsButton(QPushButton):
    def __init__(self, x, y, p, s):
        super().__init__()
        self._x = x
        self._y = y
        self._parent = p
        self.setFixedSize(s, s)
        self.clicked.connect(self._click)
        self.setStyleSheet("background-color: White")

    #when the buttons get clicked we connect it to
    #the click method when a button is clicked, passed down to GameWindow Class through the parent variable
    #There we have a method called button_clicked, we pass the position of the  currently clicked button to it
    
    def _click(self):
        self._parent.button_clicked(self._x, self._y)
        #self._parent.randomSimulation(self._x, self._y)
        
        
#Game Class with the Button Board, with QMainWindow inheritated
class GameWindow(QMainWindow):
    def __init__(self, dim=40, buttonSize=20, parent=None):
        super().__init__(parent)
        
        #Properties of window, size, Icons, title
        self.setFixedSize(900, 880)
        self.setWindowTitle("Game of Life")
        self.setWindowIcon(QtGui.QIcon('./my_pictures/logoIcon.jpeg'))
        
        
        #Defining, dims and button size
        self.dim = dim
        self.buttonSize = buttonSize
        self.cells = [[False for _ in range(self.dim)]
                        for _ in range(self.dim)]
        
        
        #calling methods inside our Class
        self.setupUI()
        self.setupMenu()
        self.startSimulation()
        
        
    #setup the Button Interface
    def setupUI(self):
        self.centralwidget = QWidget()
        self.setCentralWidget(self.centralwidget)
        self.gridLayout = QGridLayout(self.centralwidget)
        self.gridLayout.setSpacing(0)
        self.gridLayout.setContentsMargins(30,30,0,10)
        self.resize(self.buttonSize * (self.dim + 1), self.buttonSize * (self.dim + 1))

        self.buttons = []
        for i in range(self.dim):
            l = []
            for j in range(self.dim):
                b = fieldsButton(i, j, self, self.buttonSize)
                l.append(b)
                self.gridLayout.addWidget(b, i, j)
                self.gridLayout.setColumnMinimumWidth(j, self.buttonSize)
            self.buttons.append(l)
        
        
    #SetUp the Menu with the bar
    def setupMenu(self):
        #QKeySequence allows us to acces the keyboards keys, instead of space, try writing a or x
        self.shortcutSpace = QShortcut(QKeySequence('space'), self)
        self.shortcutSpace.activated.connect(self.keyBoardPress_Space)

        #When Using Buttons, we use clicked.connect, For menubar Actions we use triggered.connect 
        #and then bind it to a function
        menubar = self.menuBar()
        startAction = QAction('Start', self)
        #startAction.triggered.connect(self.randomSimulation) #FIXME: FIX THIS LINE 
        menubar.addAction(startAction)
        
        pauseAction = QAction('Pause', self)
        pauseAction.triggered.connect(self.pauseGame)
        menubar.addAction(pauseAction)
        
        
        clearAct = QAction('Reset', self)
        clearAct.triggered.connect(self.reset_Board)
        menubar.addAction(clearAct)

        #help button for rules
        helpAct = QAction('Help', self)
        helpAct.triggered.connect(self.showRules)
        menubar.addAction(helpAct)
        
        #back to menu
        BackToMenuAct = QAction('Back to Menu', self)
        BackToMenuAct.triggered.connect(self.goMainWindow)
        menubar.addAction(BackToMenuAct)

        exitAct = QAction('Exit', self)
        exitAct.triggered.connect(qApp.quit)
        menubar.addAction(exitAct)
        
    #back to menu method 
    def goMainWindow(self):
        self.myAppClass = myApp()
        self.myAppClass.show()
        self.close() 
        
    #show rules of the game
    def showRules(self):
        rules = QMessageBox.information(
            self, 'Rules of the Game',
            'Any live cell with fewer than two live neighbors dies, '+
            'as if by under population.\n'+
            'Any live cell with two or three live neighbors lives on '+
            'to the next generation.\n'+
            'Any live cell with more than three live neighbors dies, '+
            'as if by overpopulation.\n'+
            'Any dead cell with exactly three live neighbors becomes '+
            'a live cell, as if by reproduction.'+
            '\n\nClick to toggle a cell between dead/alive.'
            '\nUse Spacebar to advance one generation.',
            QMessageBox.Ok
            )
        
        
    #clear the board by setting the color to white 
    def reset_Board(self):
        self.cells = [[False for _ in range(self.dim)]
                        for _ in range(self.dim)]
                            
        for b_row in self.buttons:
            for b in b_row:
                b.setStyleSheet("background-color: White")   
        

    #When the keyboard key is pressed, then we go to our simulation Method
    def keyBoardPress_Space(self):
        self.startSimulation()



    #when clicked, get the position, the coordinates are 
    #coming from the child class fieldsButton,
    def button_clicked(self, x, y):
        self.swap(x, y)

    #basically what this does is when the button is clicked, 
    #while it's white, then it turns black, otherwise it turns white
    def swap(self, x, y):
        self.cells[x][y] = not self.cells[x][y]
        self.buttons[x][y].setStyleSheet(
            f'background-color: {"black" if self.cells[x][y] else "white"}'
        )
        
        
        
        
    # def randomSimulation(self, x, y):
    #     #self.swap(x, y)
    #     randomNum = random.randint(25, 50)
    #     for i in range(randomNum):
    #         for x in self.cells:
                
    #             self.buttons[x][y].setStyleSheet(
    #                 f'background-color: {"black"}'
    #             )
        
        
    #     pass
        
        
        
        
    #startSimulation method
    def startSimulation(self):
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
            

    def pauseGame(self):
        pass
        
        
def main():
    app = QApplication(sys.argv)
    window = myApp()
    gameWindow = GameWindow()
    window.show()
    sys.exit(app.exec_())
    
if __name__ == '__main__':
    main()


