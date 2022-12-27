#!/bin/bash
start=$(date +%s)
python3 ./model2.py
end=$(date +%s)
echo "Elapsed Time: $(($end-$start)) seconds"
curl -X POST $CONTROLPLANEIP -H 'Content-Type: application/json' -d "{\"benchmark\":\"dl\", \"system\":\"$SYSTEM\", \"type\":\"$TYPE\", \"result\":\"$(($end-$start))\"}"