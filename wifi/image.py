#!/usr/bin/python3

# Original: Adafruit Nokia 5110 LCD library example (image.py)
# Copyright (c) 2014 Adafruit Industries
# Author: Tony DiCola ..
#
# Edited 26.4.2019 to animate wifi symbol

import time
import os

import Adafruit_Nokia_LCD as LCD
import Adafruit_GPIO.SPI as SPI

from PIL import Image

# host name to test if internet is connected
hostname = 'google.com'

# Raspberry Pi hardware SPI config:
DC = 23
RST = 24
SPI_PORT = 0
SPI_DEVICE = 0

# Hardware SPI usage:
disp = LCD.PCD8544(DC, RST, spi=SPI.SpiDev(SPI_PORT, SPI_DEVICE, max_speed_hz=4000000))

# Initialize library.
disp.begin(contrast=60)

# Clear display.
disp.clear()
disp.display()

# Load image and convert to 1 bit color.
files = ('wifi_01.ppm', 'wifi_02.ppm', 'wifi_03.ppm', 'wifi_04.ppm')
images = []
for f in files:
	images.append(Image.open(f).convert('1'))

# Display image.
disp.image(images[0])
disp.display()

print('Wait internet connection .', end='')
step = 1
current = 0
while True:
	time.sleep(0.5)
	current += step
	disp.clear()
	disp.image(images[current])
	disp.display()
	if current == len(images) - 1:
		resp = os.system('ping -c 1 -w2 {} > /dev/null 2>&1'.format(hostname))
		if resp == 0:
			break
		step = -1
	if current == 0:
		step = 1
	print('.', end='')

print()
print('Internet connected !!!')
