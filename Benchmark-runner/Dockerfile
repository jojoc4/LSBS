FROM python:3.11-bullseye
WORKDIR /usr/src/app
RUN apt update && DEBIAN_FRONTEND=noninteractive TZ=Etc/UTC apt install -y git openssh-client
RUN pip install ansible mysql-connector-python==8.0.29

COPY ./Benchmark-runner/sshconfig /root/.ssh/config

ADD ./Benchmarks/* ./bench-ansible/

COPY ./Benchmark-runner/* ./

CMD [ "bash", "run.sh" ]