FROM ubuntu:20.04
RUN apt update && DEBIAN_FRONTEND=noninteractive TZ=Etc/UTC apt install -y hpcc curl
ADD ./* /bench/
RUN chmod +x /bench/run.sh
WORKDIR /bench/
ENV OMPI_ALLOW_RUN_AS_ROOT=1
ENV OMPI_ALLOW_RUN_AS_ROOT_CONFIRM=1
ENTRYPOINT ./run.sh