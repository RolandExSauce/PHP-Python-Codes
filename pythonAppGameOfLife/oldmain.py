

""" Conways game of life """
import sys
from PyQt5.QtGui     import *
from PyQt5.QtCore    import *
from PyQt5.QtWidgets import *

from PyQt5.QtWidgets import QApplication, QPushButton, QWidget, QGridLayout
from PyQt5.QtWidgets import QMainWindow, QShortcut, QAction, qApp, QStyleFactory
from PyQt5.QtWidgets import QMessageBox
from PyQt5.QtGui import QKeySequence, QIcon
from PyQt5 import QtGui, QtCore
from PyQt5 import QtCore, QtGui, QtWidgets


class myApp(QMainWindow):
    def __init__(self):
        super().__init__()
        self.InitUI()

    def InitUI(self):
        self.setFixedSize(1120, 800)
        self.setWindowTitle("Game of Life")
        self.setWindowIcon(QtGui.QIcon('./my_pictures/logoIcon.jpeg'))

        buttonWindow1 = QPushButton('Window1', self)
        buttonWindow1.move(100, 100)
        buttonWindow1.clicked.connect(self.buttonWindow1_onClick)
        self.lineEdit1 = QLineEdit("Type here what you want to transfer for [Window1].", self)
        self.lineEdit1.setGeometry(250, 100, 400, 30)
        
        
        
        self.centralwidget = QtWidgets.QWidget(self)
        self.centralwidget.setObjectName("centralwidget")
        self.label_5 = QtWidgets.QLabel(self.centralwidget)
        self.label_5.setGeometry(QtCore.QRect(410, 200, 491, 351))
        self.label_5.setText("")
        self.label_5.setPixmap(QtGui.QPixmap("my_pictures/game3.png"))
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
        self.label_10.setPixmap(QtGui.QPixmap("my_pictures/designed_with_qt5.jpg"))
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
        self.label_12.setPixmap(QtGui.QPixmap("my_pictures/orlando_savage.png"))
        self.label_12.setObjectName("label_12")
        self.label_11 = QtWidgets.QLabel(self.centralwidget)
        self.label_11.setGeometry(QtCore.QRect(80, 710, 241, 31))
        self.label_11.setText("")
        self.label_11.setPixmap(QtGui.QPixmap("my_pictures/sur_and_given_name.jpg"))
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
    
    
    @pyqtSlot()
    def buttonWindow1_onClick(self):
        self.cams = GameWindow(self.lineEdit1.text()) 
        self.cams.show()
        self.close()
        

#for the buttons
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
        
        
        
class GameWindow(QMainWindow):
    def __init__(self, value, parent=None):
        super().__init__(parent)
        self.setFixedSize(1120, 800)
        self.setWindowTitle("Game of Life")
        self.setWindowIcon(QtGui.QIcon('./my_pictures/logoIcon.jpeg'))
        self.setupMenu()
        
        
        
        
        
        
    #Menu
    def setupMenu(self):
        self.shortcutSpace = QShortcut(QKeySequence('space'), self)
        #self.shortcutSpace.activated.connect(self.on_spacebar)

        menubar = self.menuBar()
        startAction = QAction('Start', self)
        #startAction.triggered.connect(self.evolve)
        menubar.addAction(startAction)

        pauseAction = QAction('Pause', self)
        pauseAction.triggered.connect(self.pauseGame)
        menubar.addAction(pauseAction)
        
        
        clearAct = QAction('Reset', self)
        #clearAct.triggered.connect(self._clear)
        menubar.addAction(clearAct)

        helpAct = QAction('Help', self)
        helpAct.triggered.connect(self.help_popup)
        menubar.addAction(helpAct)
        
        
        BackToMenuAct = QAction('Back to Menu', self)
        BackToMenuAct.triggered.connect(self.goMainWindow)
        menubar.addAction(BackToMenuAct)

        exitAct = QAction('Exit', self)
        exitAct.triggered.connect(qApp.quit)
        menubar.addAction(exitAct)
        
        
    def goMainWindow(self):
        self.cams = myApp()
        self.cams.show()
        self.close() 
        
        
    def help_popup(self):
        message = QMessageBox.information(
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

    def pauseGame(self):
        pass
        
        

if __name__ == '__main__':
    app=QApplication(sys.argv)
    window =myApp()
    window.show()
    sys.exit(app.exec_())
    








