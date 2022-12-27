FROM ubuntu:20.04
RUN apt update && DEBIAN_FRONTEND=noninteractive TZ=Etc/UTC apt install -y fio curl
ADD ./Benchmarks/files/fio/* /bench/
RUN chmod +x /bench/run.sh
WORKDIR /bench/
ENTRYPOINT ./run.sh