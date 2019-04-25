# rpi_radio
rpi zero based web radio

1) create headless rasbian image for rpi zero
  - flash raspbian sketch lite (https://www.raspberrypi.org/downloads/raspbian/) to SD card
  - setup ssh on startup (create file "ssh" on /boot section)
  - setup wifi on startup https://raspberrypi.stackexchange.com/questions/10251/prepare-sd-card-for-wifi-on-headless-pi
  
## example wifi setup file

    ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev
    update_config=1
    country=cz
    
    network={
        ssid="mySSID"
        psk="myPASSWORD"
        key_mgmt=WPA-PSK
    }
    
2) connect with ssh and run raspi-config
  - sudo raspi-config
  - set interfacing options / ssh enabled (pernamently - not by ssh file in boot)
  
