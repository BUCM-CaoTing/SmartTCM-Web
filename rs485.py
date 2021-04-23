import serial
from socket import *
import time
from threading import Thread

areaId = 1
HOST = '106.15.59.9' # or 'localhost'
PORT = 12001
BUFSIZ = 1024
ADDR = (HOST, PORT)

t = 0


def getSerial():
    print("serial")
    while True:
        count = ser.inWaiting()
        if count != 0:
            recv = ser.read(count)
            if recv:
                tcpCliSock.send(recv)
                print(recv)
                ser.flushInput()
                time.sleep(0.001)

def getSocket():
    print("socket")
    while True:
        recv = tcpCliSock.recv(BUFSIZ)
        if recv:
            print(recv)
            ser.write(recv)

def heartBeat():
    tcpCliSock.send(b"0,1")
    t = int(time.time())
    while True:
        t1 = int(time.time())
        if t1 - t > 20:
            tcpCliSock.send(b"0,1")
            t = t1

tcpCliSock = socket(AF_INET, SOCK_STREAM)
tcpCliSock.connect(ADDR)


ser = serial.Serial("/dev/ttyUSB0", 115200)
recv = ""


if __name__ == '__main__':
# while True:
#     heartBeat()
#     getSerial()
#     getSocket()
    print("主线程开始")
    tcpCliSock.send(b"0,1")
    t1 = Thread(target=heartBeat)
    t2 = Thread(target=getSerial)
    t3 = Thread(target=getSocket)
    t1.start()
    t2.start()
    t3.start()
    print("主线程结束")

