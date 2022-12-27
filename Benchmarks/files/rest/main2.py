from flask import Flask 
from flask import request
from flask import send_file
import requests
import subprocess
import os
from random import randrange
import threading

def askFile():
    with open('output_file', 'wb') as fout:
        fout.write(os.urandom(573741824))
    requests.get(url="http://"+os.getenv('SERVERNAME')+":81/downfile2")

app = Flask(__name__)

@app.route("/file")
def file():
    return send_file('output_file', as_attachment=True)

@app.route("/quit")
def end():
    return subprocess.Popen("kill "+str(os.getpid()), shell=True, stdout=subprocess.PIPE).stdout.read()


x = threading.Thread(target=askFile)
x.start()

