#!/bin/bash
case "$BENCHMARK" in

0)
   k0s kubectl run hpcc --image=registry.jojoc4.ch/tm-hpcc --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --restart=Never --request-timeout=0
   while [[ $(k0s kubectl get pods hpcc --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete pod hpcc --now

   k0s kubectl run fio --image=registry.jojoc4.ch/tm-fio --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --restart=Never --request-timeout=0
   while [[ $(k0s kubectl get pods fio --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete pod fio --now

   k0s kubectl run iperf --image=jojoc4/lsbs-iperf --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --env="SERVERNAME=$SERVERNAME" --restart=Never --request-timeout=0
   while [[ $(k0s kubectl get pods iperf --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete pod iperf --now

   k0s kubectl run blender --image=registry.jojoc4.ch/tm-blender --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --restart=Never --request-timeout=0
   while [[ $(k0s kubectl get pods blender --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete pod blender --now

   k0s kubectl run dl --image=registry.jojoc4.ch/tm-dl --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --restart=Never --request-timeout=0
   while [[ $(k0s kubectl get pods dl --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete pod dl --now

   k0s kubectl run bdd --image=jojoc4/lsbs-bdd --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --restart=Never --request-timeout=0
   while [[ $(k0s kubectl get pods bdd --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete pod bdd --now

   k0s kubectl run rest --image=registry.jojoc4.ch/tm-rest --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --env="SERVERNAME=$SERVERNAME" --restart=Never --request-timeout=0 --port=5000
   k0s kubectl expose --type=NodePort pod rest --port 5000 --name web  --overrides '{ "apiVersion": "v1","spec":{"ports": [{"port":5000,"protocol":"TCP","targetPort":5000,"nodePort":30500}]}}'
   while [[ $(k0s kubectl get pods rest --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete svc web
   k0s kubectl delete pod rest --now
   ;;
1) k0s kubectl run hpcc --image=registry.jojoc4.ch/tm-hpcc --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --restart=Never --request-timeout=0
   while [[ $(k0s kubectl get pods hpcc --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete pod hpcc --now
   ;;
2) k0s kubectl run fio --image=registry.jojoc4.ch/tm-fio --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --restart=Never --request-timeout=0
   while [[ $(k0s kubectl get pods fio --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete pod fio --now
   ;;
3) k0s kubectl run iperf --image=jojoc4/lsbs-iperf --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --env="SERVERNAME=$SERVERNAME" --restart=Never --request-timeout=0
   while [[ $(k0s kubectl get pods iperf --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete pod iperf --now
   ;;
4) k0s kubectl run blender --image=registry.jojoc4.ch/tm-blender --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --restart=Never --request-timeout=0
   while [[ $(k0s kubectl get pods blender --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete pod blender --now
   ;;
5) k0s kubectl run bdd --image=jojoc4/lsbs-bdd --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --restart=Never --request-timeout=0
   while [[ $(k0s kubectl get pods bdd --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete pod bdd --now
   ;;
6) k0s kubectl run dl --image=registry.jojoc4.ch/tm-dl --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --restart=Never --request-timeout=0
   while [[ $(k0s kubectl get pods dl --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete pod dl --now
   ;;
7) k0s kubectl run rest --image=registry.jojoc4.ch/tm-rest --env="CONTROLPLANEIP=$CONTROLPLANEIP" --env="SYSTEM=$SYSTEM" --env="TYPE=$TYPE" --env="SERVERNAME=$SERVERNAME" --restart=Never --request-timeout=0 --port=5000
   k0s kubectl expose --type=NodePort pod rest --port 5000 --name web  --overrides '{ "apiVersion": "v1","spec":{"ports": [{"port":5000,"protocol":"TCP","targetPort":5000,"nodePort":30500}]}}'
   while [[ $(k0s kubectl get pods rest --no-headers -o custom-columns=":status.phase") != "Succeeded" ]]; do
      sleep 1
   done
   k0s kubectl delete svc web
   k0s kubectl delete pod rest --now
   ;;
esac