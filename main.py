import selenium.webdriver
import selenium.webdriver
import selenium.webdriver.support.ui
import selenium.webdriver.support.expected_conditions
import selenium.common.exceptions
import selenium.webdriver.common.by
from selenium.webdriver.common.by import By
import os
import time
from datetime import datetime, timedelta

loginUrl = 'https://sso.daegu.ac.kr/dgusso/ext/lms/login_form.do?Return_Url=http://lms.daegu.ac.kr/ilos/lo/login_sso.acl'

driver = selenium.webdriver.Chrome(os.path.dirname(os.path.realpath(__file__))+ '/chromedriver')

def login_service():
    driver.get(loginUrl)

    username = 'ENTER YOUR ID'
    password = 'ENTER YOUR PASSWD'

    driver.find_element_by_id('usr_id').send_keys(username)
    driver.find_element_by_id('usr_pw').send_keys(password)

    driver.find_element_by_class_name('btn_login').click()

def attendance_info():
    driver.find_element_by_xpath('//*[@id="list_subject"]/tbody/tr[2]').click()
    print(driver.find_element_by_xpath('//*[@id="course"]/li[1]/label').text + ' : ' + driver.find_element_by_xpath('//*[@id="course"]/li[1]/span').text)
    print(driver.find_element_by_xpath('//*[@id="summary"]').text + '\n')
    driver.find_element_by_xpath('//*[@id="menu"]/li[1]').click()


def find_schedule():
    nowDate = datetime.now()
    limit = 0 #일정 개수 카운트 변수
    i=0
    for i in range(0, 15):
        setDate = (nowDate+timedelta(days=i))
        getDate = setDate.strftime('%#m_%#d')
        driver.find_element_by_id(getDate).click() #오늘날짜까지 출력 완료
        print("["+getDate+"]") #날짜 출력
        
        try:
            print(driver.find_element_by_xpath('//*[@id="shedule_calendar_form"]/div[2]').text) #일정 출력
        except:
            print("error") #일정이 없어도 예외는 발생 X (테스트용 구문)
            continue
        print("")

def my_course():
    driver.find_element_by_class_name('icon-nm').click()
    lecture_count = 2
    while(True):
        try:
            count_str = str(lecture_count)
            print(driver.find_element_by_xpath('//*[@id="lecture_list"]/div[1]/div[1]/div['+count_str+']').text)
            lecture_count = lecture_count+1
            print("")
        except:
            break #정규과목 존재하지 않을 때 종료
    
        

if __name__ == "__main__":
    login_service()
    time.sleep(1)
    find_schedule()
    time.sleep(1)
    my_course()
    time.sleep(1)
