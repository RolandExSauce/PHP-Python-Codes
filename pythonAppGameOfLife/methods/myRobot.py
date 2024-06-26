#Using properties, get and setter in python
class mySuperRobot:
    def __init__(self):
        
        #we define private variables using __
        #we have a name for our robot, the task he should do, stored in a list, then his current status
        self._name = str() #empty string for the name
        self._task: list = ["cooking", "cleaning", "charging"] #list for robot duties
        self._robotStatus = int() #switch robot on and off, on == 1, off == 0
        
        
        
    # We will be the using property decorator on the getter functions
    @property
    def getName(self):
        pass
        
        #return self._name #the name which get passed from the input below will be retrieved here

    # getName setter function, we specify the getName function, to be correct it's no longer a function but a property, 
    #note that we dont have to call the getName function inside the setname function, that's the purpose of using properties
    @getName.setter
    def setName(self, name):
        print("You named your Robot " +str(name) + "\n") #we set the name, with the variable we got from the input
        self._name = name #initialising the private variable self.__name to the current name 
        return name 
    
    #By the same logic we handle the way how the satus and the tasks are retrieved 
    @property
    def getStatus(self):
        return self._robotStatus

    #status setter function
    @getStatus.setter
    def setStatus(self, status):
        if (status == 1): 
            print("Your Robot is now online, you can use it!\n")
        else:
            print("Your Robot is offline, you cannot use it!\n")
        self._robotStatus = status
        return status

    @property
    def getTask(self):
        #print("The task was retrieved!")
        return self._task

    # task setter function
    @getTask.setter
    def seTask(self, task):
        robotStatus = self.setStatus
        if(task == "A" ) and robotStatus == 1:
            print( str(self._name) + " is " + str(self._task[0]))
        elif (task == "B" ) and  robotStatus == 1:
            print(str(self._name) + " is " + str(self._task[1]))
        elif (task == "C") and  robotStatus == 1:
            print(str(self._name) + " is " + str(self._task[2]))
            self._task = task
        else: 
            print("It looks like you didn't turn on your Robot! Robots cannot be used in Offline mode!\n")
        
newRobotInstance = mySuperRobot() #initialising new class instance then asking for user input through properties
newRobotInstance.setName = str(input("Give your Robot a name: "))
newRobotInstance.setStatus = int(input("\nType 1 to switch robot on, 0 to switch robot off: "))
newRobotInstance.seTask  = str(input("If your Robot is turned on, try to use it\nWhat should your robot do ?\n\nType A for Cooking, Type B for Cleaning, Type C for charging: "))

