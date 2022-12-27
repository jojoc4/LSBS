FROM nvcr.io/nvidia/tensorflow:22.08-tf2-py3
RUN apt update && DEBIAN_FRONTEND=noninteractive TZ=Etc/UTC apt install -y python3-pip unzip curl
ADD ./* /bench/
ADD img /bench/img
RUN chmod +x /bench/run.sh
WORKDIR /bench/
RUN pip3 install -r requirements.txt
ENTRYPOINT ./run.sh