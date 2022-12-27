#!/bin/bash
start=$(date +%s)
./sel
end=$(date +%s)
echo "Elapsed Time: $(($end-$start)) seconds"
curl -X POST $CONTROLPLANEIP -H 'Content-Type: application/json' -d "{\"benchmark\":\"bdd\", \"system\":\"$SYSTEM\", \"type\":\"$TYPE\", \"result\":\"$(($end-$start))\"}"