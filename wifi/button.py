#!/usr/bin/python3

import RPi.GPIO as GPIO
from time import sleep

def btn1():
	return (GPIO.input(20) == 0)

def btn2():
	return (GPIO.input(21) == 0)

GPIO.setmode(GPIO.BCM)
GPIO.setwarnings(False)
GPIO.setup(20, GPIO.IN, pull_up_down=GPIO.PUD_UP)
GPIO.setup(21, GPIO.IN, pull_up_down=GPIO.PUD_UP)
GPIO.setup(17, GPIO.OUT)

btn1s = btn2s = False

while True:
	tmp1 = btn1()
	tmp2 = btn2()
	if tmp1 != btn1s:
		print('Button 1 {}'.format('PRESSED' if tmp1 else 'RELEASED'))
		btn1s = tmp1
	if tmp2 != btn2s:
		print('Button 2 {}'.format('PRESSED' if tmp2 else 'RELEASED'))
		btn2s = tmp2
	sleep(0.1)
