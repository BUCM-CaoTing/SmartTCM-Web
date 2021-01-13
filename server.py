import socket
import threading
import requests
import json

class WSGIServer(object):
    addrs = []
    headers = {'content-type': 'application/x-www-form-urlencoded',
               'User-Agent': 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:22.0) Gecko/20100101 Firefox/22.0'}

    def __init__(self, port):
        self.tcp_server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.tcp_server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        self.tcp_server_socket.bind(("", port))
        self.tcp_server_socket.listen(100)

    def run_forever(self):
        while True:
            new_socket, client_addr = self.tcp_server_socket.accept()
            print("{0} connect".format(client_addr))
            t1 = threading.Thread(target=self.service_machine, args=(new_socket, client_addr))
            t1.start()

    def service_machine(self, new_socket, client_addr):
        areaId = ""
        while True:
            # if areaId != "":
            #     print("get task")
            if areaId != "":
                data = {'areaId': areaId}
                response = requests.post('http://106.15.59.9:12000/index.php/task/get', data=data,
                                         headers=self.headers, verify=False)
                body = json.loads(response.body)

                task = "14," + body.deviceId + "," + body.task
                new_socket.send(task.encode())


                print(response)
            try:
                receive_data = new_socket.recv(1024).decode("utf-8")
                if receive_data:
                    print(receive_data)
                    arr = receive_data.split(',')
                    if (arr[0] == "0"):
                        areaId = arr[1]
                        data = {'areaId': areaId, 'client': client_addr}
                        response = requests.post('http://106.15.59.9:12000/index.php/api/arealogin', data=data, headers=self.headers, verify=False)
                        print(response)
                        print("post areaId")
                    if areaId != "":
                        if (arr[0] == "1"):
                            deviceId = arr[1]
                            temperature = arr[2]
                            humidity = arr[3]
                            data = {'areaId': areaId, 'deviceId': deviceId, 'value': temperature + '|' + humidity}
                            requests.post('http://106.15.59.9:12000/index.php/api/post', data=data, headers=self.headers, verify=False)
                        if (arr[0] == "2"):
                            deviceId = arr[1]
                            hum = arr[2]
                            data = {'areaId': areaId, 'deviceId': deviceId, 'value': hum}
                            requests.post('http://106.15.59.9:12000/index.php/api/post', data=data, headers=self.headers, verify=False)
                        if (arr[0] == "3"):
                            deviceId = arr[1]
                            gzd = arr[2]
                            data = {'areaId': areaId, 'deviceId': deviceId, 'value': gzd}
                            requests.post('http://106.15.59.9:12000/index.php/api/post', data=data, headers=self.headers, verify=False)
                        if (arr[0] == "4"):
                            deviceId = arr[1]
                            waterSWstatu = arr[2]
                            tempSWstatu = arr[3]
                            ledSWstatu = arr[4]
                            data = {'areaId': areaId, 'deviceId': deviceId, 'value': waterSWstatu + '|' + tempSWstatu + '|' + ledSWstatu}
                            requests.post('http://106.15.59.9:12000/index.php/api/post', data=data, headers=self.headers, verify=False)



            except:
                requests.post('http://106.15.59.9:12000/index.php/api/arealogout', data={}, headers=self.headers, verify=False)
                print("disconnect")
                break





                #new_socket.send(response.encode("utf-8"))
            # else:
            #     print('{0} disconnect..'.format(client_addr))
            #     break

        #new_socket.close()
        print("aaa")


def main(port):
    wsgi_server = WSGIServer(port)
    wsgi_server.run_forever()

if __name__ == '__main__':
    main(12001)
