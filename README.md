# rpi_radio
rpi zero based web radio

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
  
## todo
  - connect display, buttons and audio output
  - display: https://www.algissalys.com/how-to/nokia-5110-lcd-on-raspberry-pi
  - audio: https://learn.adafruit.com/introducing-the-raspberry-pi-zero/audio-outputs
  
