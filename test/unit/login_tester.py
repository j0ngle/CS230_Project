from selenium import webdriver
PATH = 'C:/Program Files (x86)/chromedriver.exe'

import time

driver = webdriver.Chrome(PATH)

driver.get("http://52.201.250.219/login.php")

file = open("users.txt","r")

# log into 50 accounts cuz why not
for i in range(0, 50):
	userInfo = file.readline()
	userInfo = userInfo.split(" ")
	driver.find_element_by_name("uname").send_keys(userInfo[2])
	driver.find_element_by_name("pwd").send_keys(userInfo[4])
	driver.find_element_by_name("login-submit").click()
	driver.get("http://52.201.250.219/includes/logout.php")

file.close()
driver.quit()