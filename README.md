<h1 align="center">
  LSBS
</h1>

<div align="center">
  Linux Servers Benchmarking System
  <br />
</div>

<div align="center">
<br />

[![license](https://img.shields.io/github/license/dec0dOS/amazing-github-template.svg?style=flat-square)](LICENSE)
[![made with hearth by dec0dOS](https://img.shields.io/badge/made%20with%20%E2%99%A5%20by-jojoc4-ff1414.svg?style=flat-square)](https://github.com/jojoc4)

</div>

<details open="open">
<summary>Table of Contents</summary>

- [About](#about)
- [Architecture](#architecture)
- [Installation](#installation)
  - [Control plane](#control-plane)
    - [Automated installation](#automated-installation)
    - [Manual installation](#manual-installation)
  - [Target systems](#target-systems)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

</details>

---

## About

Linux Servers Benchmarking System is a tool that was designed to measure the loss of performance of a workload executed on a server, a VM, a container or a combination of these. for example: application in k8s on vm on hyper-v.

Benchmarks where conducted on three different systems with 17 combination of hypervisors and/or container runtimes.

The tests are these:

- HPL
- DGEMM
- Stream
- Random Access
- FIO
- Blender classroom render
- Deep learning model training
- Database operations
- REST API

## Architecture

The system is composed of a control plane and one or more tested systems. a tested system is made of one or more targets with the exact same configuration. this can be used to accelerate the benchmarks but it can also reduce the iperf and rest benchmark accuracy.

## Installation

### Control plane

the control plane uses a docker file with multiple docker container. It should be in the same network as the target systems.

#### Automated installation

To use the automated installation, you need ansible on your local machine and the possibility to connect to the control plane machine with a non-root user with an ssh key. this user must have password-less sudo permission. The OS must be Rocky Linux >=8.6.
To install Docker and run the control plane, update the values in `Control-plane/inventory.yaml` and change the ip addresse of `CPIP`in `Control-plane/files/docker-compose.yaml`. Then, run

```bash
ansible-playbook -i Control-plane/inventory.yaml Control-plane/docker.yaml
```

The web-interface should be available at [http://IP_OR_FQDN/]().

The Database can be managed at [http://IP_OR_FQDN:8080/]() with user root and password example.

#### Manual installation

To mannualy install the control plane, prepare a machine with docker and docker compose. [Follow the official documentation](https://docs.docker.com/engine/install/).
Once done, use this command to setup the control plane:

```bash
cd Control-plane && docker compose up -d
```

The web-interface should be available at [http://IP_OR_FQDN/]().

The Database can be managed at [http://IP_OR_FQDN:8080/]() with user root and password example.

### Target systems

The target system must be installed with an ubuntu 20.04 LTS. Once installed, create the file `/root/.ssh/authorized_keys` and put the following public key inside:

```
ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIM4HXzVtsfkJm+xNcT17O0LZNWi6EWDOWvI6LqeJVNHJ LSBS@github.com
```

It is recommended to reinstall the OS each time another type of benchmark is used. for example when going from bare-metal to docker on bare-metal.

Be carefull to always install it the exact same way. Use a full ISO as a base and avoid all updates to ensure the packages versions are the same.

## Usage

To use the system, First open a web browser on the control plane. you can then add your systems and targets.
![](https://pix.milkywan.fr/uNJCJlTC)
Then you can go on schedule and choose what benchmark you want to execute. Benchmarks on a same target will be executed sequentially.
![](https://pix.milkywan.fr/NsxV5diX)
Finally, onc they are done, you can visualize the results.
![](https://pix.milkywan.fr/BcetXleJ)

## Contributing

First off, thanks for taking the time to contribute! Contributions are what makes the open-source community such an amazing place to learn, inspire, and create. Any contributions you make will benefit everybody else and are greatly appreciated.

Please try to create bug reports that are:

- Reproducible. Include steps to reproduce the problem.
- Specific. Include as much detail as possible: which version, what environment, etc.
- Unique. Do not duplicate existing opened issues.
- Scoped to a Single Bug. One bug per report.

## License

This project is licensed under the **MIT license**. Feel free to edit and distribute this template as you like.

See [LICENSE](LICENSE) for more information.
