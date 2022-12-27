#!/bin/bash
case "$BENCHMARK" in

0)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE jojoc4/lsbs-hpcc
    docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE jojoc4/lsbs-fio
    docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE -e SERVERNAME=$SERVERNAME jojoc4/lsbs-iperf
    docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE jojoc4/lsbs-blender
    docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE jojoc4/lsbs-dl
    docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE jojoc4/lsbs-bdd
    docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE -e SERVERNAME=$SERVERNAME -p 30500:5000 jojoc4/lsbs-rest
    ;;
1)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE jojoc4/lsbs-hpcc ;;
2)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE jojoc4/lsbs-fio ;;
3)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE -e SERVERNAME=$SERVERNAME jojoc4/lsbs-iperf ;;
4)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE jojoc4/lsbs-blender ;;
5)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE jojoc4/lsbs-bdd ;;
6)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE jojoc4/lsbs-dl ;;
7)  docker run --rm -e CONTROLPLANEIP=$CONTROLPLANEIP -e SYSTEM=$SYSTEM -e TYPE=$TYPE -e SERVERNAME=$SERVERNAME -p 30500:5000 jojoc4/lsbs-rest ;;

esac
docker system prune -af