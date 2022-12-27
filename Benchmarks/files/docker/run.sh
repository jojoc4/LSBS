#!/bin/bash
case "$BENCHMARK" in

0)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE registry.jojoc4.ch/tm-hpcc
    docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE registry.jojoc4.ch/tm-fio
    docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE -e SERVERNAME=$SERVERNAME jojoc4/lsbs-iperf
    docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE registry.jojoc4.ch/tm-blender
    docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE registry.jojoc4.ch/tm-dl
    docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE registry.jojoc4.ch/tm-bdd
    docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE -e SERVERNAME=$SERVERNAME -p 30500:5000 registry.jojoc4.ch/tm-rest
    ;;
1)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE registry.jojoc4.ch/tm-hpcc ;;
2)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE registry.jojoc4.ch/tm-fio ;;
3)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE -e SERVERNAME=$SERVERNAME jojoc4/lsbs-iperf ;;
4)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE registry.jojoc4.ch/tm-blender ;;
5)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE registry.jojoc4.ch/tm-bdd ;;
6)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE registry.jojoc4.ch/tm-dl ;;
7)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE -e SERVERNAME=$SERVERNAME -p 30500:5000 registry.jojoc4.ch/tm-rest ;;

esac
docker system prune -af