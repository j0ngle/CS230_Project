from selenium import webdriver
PATH = 'C:/Program Files (x86)/chromedriver.exe'

import time
import random

dictionary = ["a", "b", "c", "d", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0"]

# generate name, generates a name with length between min and max
def genName(min, max):
	name = ""
	for i in range(0, random.randint(min, max)):
		name = name + dictionary[random.randint(0, len(dictionary)-1)]
	return name

driver = webdriver.Chrome(PATH)

driver.get("http://52.201.250.219/signup.php")

file = open("users2.txt","w")

# create 50 accounts cuz why not
for i in range(0, 50):
	userInfo = [genName(6, 10), genName(6, 10), genName(6, 10), genName(6, 10) + "@" + genName(4,6) + "." + genName(3,3), genName(6, 10), genName(6, 10)]
	driver.find_element_by_name("fname").send_keys(userInfo[0])
	driver.find_element_by_name("lname").send_keys(userInfo[1])
	driver.find_element_by_name("uname").send_keys(userInfo[2])
	driver.find_element_by_name("email").send_keys(userInfo[3])
	driver.find_element_by_name("pwd").send_keys(userInfo[4])
	driver.find_element_by_name("con-pwd").send_keys(userInfo[4])
	driver.find_element_by_name("genre").send_keys(userInfo[5])

	# store the user info for login later
	for i in range(len(userInfo)):
		file.write(userInfo[i])
		file.write(" ")
	file.write("\n")
	driver.find_element_by_name("signup-submit").click()

	time.sleep(1)

file.close()
driver.quit()
