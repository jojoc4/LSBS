FROM ubuntu:20.04
RUN apt update && DEBIAN_FRONTEND=noninteractive TZ=Etc/UTC apt install -y build-essential libsqlite3-dev curl
ADD ./Benchmarks/files/bdd* /bench/
RUN chmod +x /bench/run.sh
WORKDIR /bench/
RUN gcc sel.c -o sel  -lsqlite3
ENTRYPOINT ./run.sh