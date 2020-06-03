#-*- coding: utf-8 -*-
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
#options = Options()
#options.add_argument('--headless')
#options.add_argument('--no-sandbox')

attend = 'https://sso.daegu.ac.kr/dgusso/ext/attend/login_form.do?Return_Url=http://attend.daegu.ac.kr' # attendance
schedule = 'https://sso.daegu.ac.kr/dgusso/ext/lms/login_form.do?Return_Url=http://lms.daegu.ac.kr/ilos/lo/login_sso.acl' # lms

driver = selenium.webdriver.Chrome()

def login_service_attend():
	driver.get(attend)

	username=''
	password=''

	driver.find_element_by_id('usr_id').send_keys(username)
	driver.find_element_by_id('usr_pw').send_keys(password)

	driver.find_element_by_class_name('btn_login').click()

def login_service_schedule():
	driver.get(schedule)

	username=''
	password=''

	driver.find_element_by_id('usr_id').send_keys(username)
	driver.find_element_by_id('usr_pw').send_keys(password)

	driver.find_element_by_class_name('btn_login').click()

def attendance_info():
	i = 2
	attend = ""
	try:
		while(True):
			j = str(i)
			driver.find_element_by_xpath('//*[@id="list_subject"]/tbody/tr['+j+']').click()
			
			temp1 = driver.find_element_by_xpath('//*[@id="course"]/li[1]/label').text + ' : ' + driver.find_element_by_xpath('//*[@id="course"]/li[1]/span').text + '\n'
			attend += temp1

			temp2 = driver.find_element_by_xpath('//*[@id="summary"]').text + '\n'
			attend += temp2+'\n'

			driver.find_element_by_xpath('//*[@id="menu"]/li[1]').click()
			i=i+1
	except:
		print('출석현황 조회완료')
		eattend = attend.encode('utf-8')
		file = open('/home/tay97kim/attendance_output_Kim.txt', 'w')

		file.write(eattend)
		
		file.close()
		driver.quit
    


def find_schedule():

	nowDate = datetime.now()
	limit = 0 #일정 개수 카운트 변수
	i=0
	sche = ""
	for i in range(0, 5):
		setDate = (nowDate+timedelta(days=i))
		getDate = setDate.strftime('%-m_%-d')
		driver.find_element_by_id(getDate).click()
		sche += getDate+'\n' #날짜 기록
        
		try:
			sche += driver.find_element_by_xpath('//*[@id="shedule_calendar_form"]/div[2]').text+'\n' #해당일자 일정 기록
		except:
			continue
		#print("")
		sche += '\n'
	esche = sche.encode('utf-8')
	file = open('/home/tay97kim/schedule_output_Kim.txt', 'w')

	file.write(esche)
		
	file.close()
	driver.quit

'''def my_course():
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
	driver.quit''' #미사용
    
        

if __name__ == "__main__":


	#login_service_attend()
	#time.sleep(1)
	#attendance_info()
	#time.sleep(1)
	login_service_schedule()
	time.sleep(1)
	find_schedule()

