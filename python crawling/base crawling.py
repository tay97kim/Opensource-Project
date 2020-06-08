import selenium.webdriver
import selenium.webdriver
import selenium.webdriver.support.ui
import selenium.webdriver.support.expected_conditions
import selenium.common.exceptions
import selenium.webdriver.common.by
from selenium.webdriver.common.by import By
import os
import time

loginUrl = 'https://sso.daegu.ac.kr/dgusso/ext/attend/login_form.do?Return_Url=http://attend.daegu.ac.kr:8081/'

driver = selenium.webdriver.Chrome(os.path.dirname(os.path.realpath(__file__))+ '/chromedriver')

def login_service():
    driver.get(loginUrl)

    username = '*****'
    password = '*****'

    driver.find_element_by_id('usr_id').send_keys(username)
    driver.find_element_by_id('usr_pw').send_keys(password)

    driver.find_element_by_class_name('btn_login').click()

def attendance_info():
    driver.find_element_by_xpath('//*[@id="list_subject"]/tbody/tr[2]').click()
    print(driver.find_element_by_xpath('//*[@id="course"]/li[1]/label').text + ' : ' + driver.find_element_by_xpath('//*[@id="course"]/li[1]/span').text)
    print(driver.find_element_by_xpath('//*[@id="summary"]').text + '\n')
    driver.find_element_by_xpath('//*[@id="menu"]/li[1]').click()


if __name__ == "__main__":
    login_service()
    time.sleep(1)
    attendance_info()
    time.sleep(1)