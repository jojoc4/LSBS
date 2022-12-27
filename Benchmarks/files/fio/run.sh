#!/bin/bash
DISK_TEST=$(fio --filename=/file --size=2GB --direct=1 --rw=randrw --bs=4k --ioengine=libaio --iodepth=256 --runtime=60 --numjobs=2 --time_based --group_reporting --name=iops-test-job --minimal 2> /dev/null | grep iops-test-job)
DISK_IOPS_R=$(echo $DISK_TEST | awk -F';' '{print $8}')
DISK_IOPS_W=$(echo $DISK_TEST | awk -F';' '{print $49}')

DISK_TEST2=$(fio --filename=/file --size=2GB --direct=1 --rw=rw --bs=4k --ioengine=libaio --iodepth=256 --runtime=60 --numjobs=2 --time_based --group_reporting --name=iops-test-job --minimal 2> /dev/null | grep iops-test-job)
DISK_IOPS_R2=$(echo $DISK_TEST2 | awk -F';' '{print $8}')
DISK_IOPS_W2=$(echo $DISK_TEST2 | awk -F';' '{print $49}')

DISK_TEST3=$(fio --filename=/file --size=2GB --direct=1 --rw=randrw --bs=64k --ioengine=libaio --iodepth=64 --runtime=60 --numjobs=2 --time_based --group_reporting --name=iops-test-job --minimal 2> /dev/null | grep iops-test-job)
DISK_TEST_R3=$(echo $DISK_TEST3 | awk -F';' '{print $7}')
DISK_TEST_W3=$(echo $DISK_TEST3 | awk -F';' '{print $48}')

DISK_TEST4=$(fio --filename=/file --size=2GB --direct=1 --rw=rw --bs=64k --ioengine=libaio --iodepth=64 --runtime=60 --numjobs=2 --time_based --group_reporting --name=iops-test-job --minimal 2> /dev/null | grep iops-test-job)
DISK_TEST_R4=$(echo $DISK_TEST4 | awk -F';' '{print $7}')
DISK_TEST_W4=$(echo $DISK_TEST4 | awk -F';' '{print $48}')

curl -X POST $CONTROLPLANEIP -H 'Content-Type: application/json' -d "{\"benchmark\":\"fio\", \"system\":\"$SYSTEM\", \"type\":\"$TYPE\", \"result\": { \"randiopsr\": \"$DISK_IOPS_R\", \"randiopsw\": \"$DISK_IOPS_W\", \"seqiopsr\": \"$DISK_IOPS_R2\", \"seqiopsw\": \"$DISK_IOPS_W2\", \"randsr\": \"$DISK_TEST_R3\", \"randsw\": \"$DISK_TEST_W3\", \"seqsr\": \"$DISK_TEST_R4\", \"seqsw\": \"$DISK_TEST_W4\"}}"