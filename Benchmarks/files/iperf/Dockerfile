FROM ubuntu:20.04
RUN apt update && DEBIAN_FRONTEND=noninteractive TZ=Etc/UTC apt install -y iperf3 iputils-ping curl
ADD ./* /bench/
RUN chmod +x /bench/run.sh
WORKDIR /bench/
ENV SERVER=false
ENV SERVERNAME="speedtest.milkywan.fr -p 9201"
ENTRYPOINT ./run.sh