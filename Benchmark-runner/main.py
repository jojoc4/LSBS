import mysql.connector
import threading
import os
import random
import string
import time
from urllib import request
from urllib.error import HTTPError
import json

WEBHOOK_URL = 'https://discord.com/api/webhooks/1045239452865400914/8OkXnZHqkCBWEth_O0q7OILauMx1vl08D3DNeZ17Gs2YEWcaDr8lIPJYn3_S7bLvJyeC'

HEADERS = {
    'Content-Type': 'application/json',
    'user-agent': 'Mozilla/5.0 (X11; U; Linux i686) Gecko/20071127 Firefox/2.0.0.11'
}

def get_file_name():
    letters = string.ascii_lowercase
    result_str = ''.join(random.choice(letters) for i in range(16))
    return result_str+".yaml"


def run_bench(job):
    
    fname=get_file_name()
    try:
        r=-1
        s=3
        for i in range(job["nb_run"]):
            payload = {
                'content': "Starting run "+i.__str__()+" out of "+job["nb_run"].__str__()+". ID Job: "+job['id_job'].__str__()
            }
            req = request.Request(url=WEBHOOK_URL, data=json.dumps(payload).encode('utf-8'),headers=HEADERS, method='POST')
            try:
                request.urlopen(req)
            except HTTPError as e:
                pass
            match job['category']:
                case 1:
                    f = open(fname, "w")
                    f.write("virtualmachines:\n  vars:\n    CONTROLPLANEIP: "+os.getenv('CPIP')+"\n    SYSTEM: "+job["system"].__str__()+"\n    TYPE: "+job["type"].__str__()+"\n  hosts:\n    vm01:\n      ansible_host: "+job["ip"]+"")
                    f.close()
                    if job["benchmark"] == None:
                        r = os.system('cd bench-ansible && ansible-playbook -i ../'+fname+' runall.yaml')
                    else:
                        match job["benchmark"]:
                            case 1:
                                r = os.system('cd bench-ansible && ansible-playbook -i ../'+fname+' hpcc.yaml')
                            case 2:
                                r = os.system('cd bench-ansible && ansible-playbook -i ../'+fname+' fio.yaml')
                            case 3:
                                r = os.system('cd bench-ansible && ansible-playbook -i ../'+fname+' iperf.yaml')
                            case 4:
                                r = os.system('cd bench-ansible && ansible-playbook -i ../'+fname+' blender.yaml')
                            case 5:
                                r = os.system('cd bench-ansible && ansible-playbook -i ../'+fname+' bdd.yaml')
                            case 6:
                                r = os.system('cd bench-ansible && ansible-playbook -i ../'+fname+' dl.yaml')
                            case 7:
                                r = os.system('cd bench-ansible && ansible-playbook -i ../'+fname+' rest.yaml')
                case 2:
                    f = open(fname, "w")
                    if job["benchmark"] == None:
                        f.write("virtualmachines:\n  vars:\n    CONTROLPLANEIP: "+os.getenv('CPIP')+"\n    BENCHMARK: 0\n    SYSTEM: "+job["system"].__str__()+"\n    TYPE: "+job["type"].__str__()+"\n  hosts:\n    vm01:\n      ansible_host: "+job["ip"]+"")
                    else:
                        f.write("virtualmachines:\n  vars:\n    CONTROLPLANEIP: "+os.getenv('CPIP')+"\n    BENCHMARK: "+job["benchmark"].__str__()+"\n    SYSTEM: "+job["system"].__str__()+"\n    TYPE: "+job["type"].__str__()+"\n  hosts:\n    vm01:\n      ansible_host: "+job["ip"]+"")
                    f.close()
                    r = os.system('cd bench-ansible && ansible-playbook -i ../'+fname+' docker.yaml')
                case 3:
                    f = open(fname, "w")
                    if job["benchmark"] == None:
                        f.write("virtualmachines:\n  vars:\n    CONTROLPLANEIP: "+os.getenv('CPIP')+"\n    BENCHMARK: 0\n    SYSTEM: "+job["system"].__str__()+"\n    TYPE: "+job["type"].__str__()+"\n  hosts:\n    vm01:\n      ansible_host: "+job["ip"]+"")
                    else:
                        f.write("virtualmachines:\n  vars:\n    CONTROLPLANEIP: "+os.getenv('CPIP')+"\n    BENCHMARK: "+job["benchmark"].__str__()+"\n    SYSTEM: "+job["system"].__str__()+"\n    TYPE: "+job["type"].__str__()+"\n  hosts:\n    vm01:\n      ansible_host: "+job["ip"]+"")
                    f.close()
                    r = os.system('cd bench-ansible && ansible-playbook -i ../'+fname+' k8s.yaml')
            s=3
            if r==0:
                s=2
            if s==3:
                break
        
        mydb = mysql.connector.connect(
        host="db",
        user="root",
        password="example",
        database="bench"
        )
        req = "UPDATE `job` SET `status` = '"+s.__str__()+"' WHERE `id_job` = "+job["id_job"].__str__()+";"
        mycursor = mydb.cursor()
        mycursor.execute(req)
        mydb.commit()
        mycursor.close()
        mydb.close()
    except Exception as e:

        mydb = mysql.connector.connect(
        host="db",
        user="root",
        password="example",
        database="bench"
        )
        req = "UPDATE `job` SET `status` = '3' WHERE `id_job` = "+job["id_job"].__str__()+";"
        mycursor = mydb.cursor()
        mycursor.execute(req)
        mydb.commit()
        mycursor.close()
        mydb.close()
    finally:
        print("Finished job id ", job["id_job"])
        os.remove(fname)



if __name__ == "__main__":
   
    while True:

        mydb = mysql.connector.connect(
          host="db",
          user="root",
          password="example",
          database="bench"
        )
        cursor = mydb.cursor(dictionary=True)
        cursor.execute("SELECT * FROM job JOIN type ON job.type=type.id_type JOIN target ON job.target=target.id_target WHERE status=0")

        jobs = cursor.fetchall()
        if cursor.rowcount > 0:
            cursor.close()
            for job in jobs:
                cursor = mydb.cursor(dictionary=True)
                cursor.execute("SELECT * FROM job WHERE status=1 AND target="+job["target"].__str__())
                jobsOnSameHost = cursor.fetchall()
                if cursor.rowcount == 0:
                    cursor.close()
                    req = "UPDATE `job` SET `status` = '1' WHERE `id_job`="+job["id_job"].__str__()+";"
                    mycursor = mydb.cursor()
                    mycursor.execute(req)
                    mydb.commit()
                    mycursor.close()
                    x = threading.Thread(target=run_bench, args=(job,))
                    print("Starting job id ", job["id_job"], " running ", job["benchmark"], " ", job["nb_run"], " times on ", job["ip"])
                    x.start()
                    break
                else: cursor.close()
        else: cursor.close()
        mydb.close()
        
