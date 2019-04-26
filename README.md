# rpi_radio
Description: Raspberry PI zero based web radio receiver with Nokia 5110 display.

## create headless rasbian image for rpi zero
  - flash raspbian sketch lite (https://www.raspberrypi.org/downloads/raspbian/) to SD card
  - setup ssh on startup (create file "ssh" on /boot section)
  - setup wifi on startup https://raspberrypi.stackexchange.com/questions/10251/prepare-sd-card-for-wifi-on-headless-pi
  
### example wifi setup file

    ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev
    update_config=1
    country=cz
    
    network={
        ssid="mySSID"
        psk="myPASSWORD"
        key_mgmt=WPA-PSK
    }
    
## connect with ssh and run raspi-config
  - sudo raspi-config
  - set interfacing options / ssh enabled (pernamently - not by ssh file in boot)
  - change password but don't forget it
  - upgrade system (sudo apt-get update; sudo apt-get upgrade)

## wire up Nokia 5110 display, test
  - https://www.algissalys.com/how-to/nokia-5110-lcd-on-raspberry-pi
  - backlight on pin 17, test: https://pythonprogramming.net/gpio-example-raspberry-pi/
  - install lcd libraries for python3 too (to run examples with python3)
    - sudo apt-get install python3-pip python3-pil
    - sudo pip3 install RPi.GPIO
    - test: python3 shapes.py

## solder and test audio filter
  - source 1: https://learn.adafruit.com/introducing-the-raspberry-pi-zero/audio-output
  - source 2: https://www.raspberrypi.org/forums/viewtopic?f=91&t=86609 (Gordon, Wed Sep 10, 2014 12:23 pm)

## todo
  - add buttons and audio output
  - audio: https://learn.adafruit.com/introducing-the-raspberry-pi-zero/audio-outputs
  
