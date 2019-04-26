#!/usr/bin/python3

# Original: Adafruit Nokia 5110 LCD library example (image.py)
# Copyright (c) 2014 Adafruit Industries
# Author: Tony DiCola ..
#
# Edited 26.4.2019 to animate wifi symbol

from time import sleep
import os
import socket

import Adafruit_Nokia_LCD as LCD
import Adafruit_GPIO.SPI as SPI

from PIL import Image, ImageDraw


def get_my_ip(host='8.8.8.8', port=80):
	s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
	s.connect((host, port))
	ip = s.getsockname()[0]
	s.close()
	return ip


# current dirrectory
dir = '/home/pi/rpi_radio/wifi/'

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
	images.append(Image.open(dir+f).convert('1'))

# Display image.
disp.image(images[0])
disp.display()

print('Wait internet connection .', end='')
step = 1
current = 0
while True:
	sleep(0.5)
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

ip = get_my_ip(hostname)
print('My IP is: {}'.format(ip))

sleep(1.0)
screen = Image.new('1', (LCD.LCDWIDTH, LCD.LCDHEIGHT))
draw = ImageDraw.Draw(screen)
draw.rectangle((0, 0, 83, 47), outline=255, fill=255)
draw.text((25, 8), 'My IP:')
draw.text((0, 22), ip)
disp.clear()
disp.image(screen)
disp.display()
