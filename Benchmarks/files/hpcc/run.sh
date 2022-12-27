#!/bin/bash
rm hpccoutf.txt
mpirun.openmpi -np $(nproc) --oversubscribe hpcc
HPLTFLOPS=$(cat hpccoutf.txt | grep HPL_Tflops | awk -F'=' '{print $2}')
DGEMMGFLOPS=$(cat hpccoutf.txt | grep SingleDGEMM_Gflops | awk -F'=' '{print $2}')
RANDOMACCESS=$(cat hpccoutf.txt | grep SingleRandomAccess_GUPs | awk -F'=' '{print $2}')
STREAM=$(cat hpccoutf.txt | grep SingleSTREAM_Copy | awk -F'=' '{print $2}')


curl -X POST $CONTROLPLANEIP -H 'Content-Type: application/json' -d "{\"benchmark\":\"hpcc\", \"system\":\"$SYSTEM\", \"type\":\"$TYPE\", \"result\": { \"hpl\": \"$HPLTFLOPS\", \"dgemm\": \"$DGEMMGFLOPS\", \"ra\": \"$RANDOMACCESS\", \"stream\": \"$STREAM\"}}"