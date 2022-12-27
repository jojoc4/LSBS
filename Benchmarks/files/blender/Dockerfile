FROM nvidia/cuda:11.3.0-devel-ubuntu20.04
RUN apt update && DEBIAN_FRONTEND=noninteractive TZ=Etc/UTC apt install -y wget bzip2 libfreetype6 libgl1-mesa-dev libglu1-mesa libxi6 libxrender1 curl
ADD ./* /bench/
RUN chmod +x /bench/run.sh
WORKDIR /bench/
RUN wget https://download.blender.org/release/BlenderBenchmark2.0/launcher/benchmark-launcher-cli-3.1.0-linux.tar.gz
RUN tar -zxvf benchmark-launcher-cli-3.1.0-linux.tar.gz
RUN ./benchmark-launcher-cli blender download 3.3.0
RUN ./benchmark-launcher-cli scenes download classroom -b 3.3.0
ENV DEVTYPE=CPU
ENTRYPOINT ./run.sh