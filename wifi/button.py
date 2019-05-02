#!/usr/bin/python3

from time import sleep
import threading

test = False

try:
    import RPi.GPIO as GPIO

except ImportError:
    test = True
    print("Can't import RPi.GPIO .. run test.")

    from flask import Flask, render_template, url_for

    app = Flask(__name__)

    btns = []
    bckl = False


    @app.route('/')
    @app.route('/<name>/')
    def hello(name=None):
        if name in ('1', '2'):
            btns.append(int(name))
        return render_template('temp.html', name=name, backlight=True if bckl else None)


def btn1():
    if not test:
        return GPIO.input(20) == 0
    else:
        if 1 in btns:
            btns.remove(1)
            return True
    return False


def btn2():
    if not test:
        return GPIO.input(21) == 0
    else:
        if 2 in btns:
            btns.remove(2)
            return True
    return False


def bcklight(on=False):
    if not test:
        GPIO.output(17, 1 if on else 0)

    else:
        global bckl
        bckl = 1 if on else 0


class ButtonsThread(threading.Thread):
    def __init__(self):

        threading.Thread.__init__(self)
        self.stop = False

        self.btn1s = False
        self.btn2s = False

    def stop(self):
        self.stop = True

    def run(self):

        if not test:
            GPIO.setmode(GPIO.BCM)
            GPIO.setwarnings(False)
            GPIO.setup(20, GPIO.IN, pull_up_down=GPIO.PUD_UP)
            GPIO.setup(21, GPIO.IN, pull_up_down=GPIO.PUD_UP)
            GPIO.setup(17, GPIO.OUT)

        while not self.stop:
            tmp = btn1()
            if tmp != self.btn1s:
                if tmp:
                    print('Button 1 PRESSED')
                    bcklight(True)
                    print('Backlight {}'.format('ON' if bckl else 'OFF'))
                self.btn1s = tmp
            tmp = btn2()
            if tmp != self.btn2s:
                if tmp:
                    print('Button 2 PRESSED')
                    bcklight(False)
                    print('Backlight {}'.format('ON' if bckl else 'OFF'))
                self.btn2s = tmp
            sleep(0.1)


if __name__ == '__main__':

    btnThread = ButtonsThread()
    btnThread.start()

    if test:
        app.run()

    while True:
        sleep(1)

    print('Finito !!!')
