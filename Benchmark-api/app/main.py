from flask import Flask
from flask import request
import requests
import time
import mysql.connector
import json

app = Flask(__name__)


from flask import request


@app.route('/')
def home():
	return "Hello World!"

@app.route('/downfile')
def getFile():
    ip = request.remote_addr
    rescode=500
    while(rescode==500):
        try:
            rescode = requests.get(url="http://"+ip+":5000/file").status_code
        except Exception as e:
            pass
    requests.get(url="http://"+ip+":5000/quit")
    return "http://"+ip+":5000/file"

@app.route('/downfile2')
def getFile2():
    ip = request.remote_addr
    rescode=500
    while(rescode==500):
        try:
            rescode = requests.get(url="http://"+ip+":30500/file").status_code
        except Exception as e:
            pass
    requests.get(url="http://"+ip+":30500/quit")
    return "http://"+ip+":30500/file"

@app.route('/result', methods=['POST'])
def getResult():
    mydb = mysql.connector.connect(
    host="db",
    user="root",
    password="example",
    database="bench"
    )
    content = request.get_json()

    b=0

    if content['benchmark']=="bdd":
        b=5
    elif content['benchmark']=="hpcc":
        b=1
    elif content['benchmark']=="fio":
        b=2
    elif content['benchmark']=="iperf":
        b=3
    elif content['benchmark']=="blender":
        b=4
    elif content['benchmark']=="dl":
        b=6
    elif content['benchmark']=="rest":
        b=7

    r=""
    if isinstance(content['result'], str):
        r = "{\"r\": \""+content['result']+"\"}"
    else:
        r = json.dumps(content['result'], indent = 4) 

    req = "INSERT INTO results (system, type, benchmark, result) VALUES ("+content['system']+", "+content['type']+", "+b.__str__()+", \""+r.replace("\"", "\\\"")+"\")"

    mycursor = mydb.cursor()
    mycursor.execute(req)

    mydb.commit()
    mydb.close()
    return "ok"


if __name__ == "__main__":
    # Only for debugging while developing
    app.run(host="0.0.0.0", debug=True, port=80)
