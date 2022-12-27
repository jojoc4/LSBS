#!/bin/bash
start=$(date +%s)
FLASK_APP=main.py flask run --host=0.0.0.0
end=$(date +%s)
echo "Elapsed Time: $(($end-$start)) seconds"
curl -X POST $CONTROLPLANEIP -H 'Content-Type: application/json' -d "{\"benchmark\":\"rest\", \"system\":\"$SYSTEM\", \"type\":\"$TYPE\", \"result\":\"$(($end-$start))\"}"