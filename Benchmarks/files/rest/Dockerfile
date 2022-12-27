FROM ubuntu:20.04
RUN apt update && DEBIAN_FRONTEND=noninteractive TZ=Etc/UTC apt install -y python3-pip curl
ADD ./Benchmarks/files/rest/* /bench/
RUN chmod +x /bench/run.sh
WORKDIR /bench/
RUN pip install -r requirements.txt
ENV SERVERNAME=""
ENTRYPOINT ./run_docker.sh