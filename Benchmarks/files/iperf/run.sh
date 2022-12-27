#!/bin/bash
if [ "$SERVER" = true ]
then
    iperf3 -s
else
    PINGRES=$(ping -c 4 $SERVERNAME | grep rtt)
    PINGRES=$(echo $PINGRES | awk -F'/' '{print $5}')
    IPERFS=$(iperf3 -c $SERVERNAME -R | grep sender)
    IPERFS=$(echo $IPERFS | awk -F' ' '{print $7}')
    SLEEP 2
    IPERFR=$(iperf3 -c $SERVERNAME | grep sender)
    IPERFR=$(echo $IPERFR | awk -F' ' '{print $7}')
    SLEEP 2
    IPERFU=$(iperf3 -c $SERVERNAME -u -b 10G | grep receiver)
    IPERFU=$(echo $IPERFU | awk -F' ' '{print $7}')

    curl -X POST $CONTROLPLANEIP -H 'Content-Type: application/json' -d "{\"benchmark\":\"iperf\", \"system\":\"$SYSTEM\", \"type\":\"$TYPE\", \"result\": { \"ping\": \"$PINGRES\", \"iperfs\": \"$IPERFS\", \"iperfr\": \"$IPERFR\", \"iperfu\": \"$IPERFU\"}}"
fi