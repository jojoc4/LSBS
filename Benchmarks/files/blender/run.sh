#!/bin/bash
start=$(date +%s)
./benchmark-launcher-cli benchmark classroom --blender-version 3.3.0 --device-type $DEVTYPE --json
end=$(date +%s)
echo "Elapsed Time: $(($end-$start)) seconds"
curl -X POST $CONTROLPLANEIP -H 'Content-Type: application/json' -d "{\"benchmark\":\"blender\", \"system\":\"$SYSTEM\", \"type\":\"$TYPE\", \"result\":\"$(($end-$start))\"}"