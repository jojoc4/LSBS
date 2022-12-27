wget https://download.blender.org/release/BlenderBenchmark2.0/launcher/benchmark-launcher-cli-3.1.0-linux.tar.gz
tar -zxvf benchmark-launcher-cli-3.1.0-linux.tar.gz
./benchmark-launcher-cli blender download 3.3.0
./benchmark-launcher-cli scenes download classroom -b 3.3.0
