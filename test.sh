#!/bin/sh
HOST='localhost'
USER='root'
PASSWD='root'
FILE='file.txt'
count=1

INT="em0"

TESTCOUNT=100

numbers=`jot - 1 $TESTCOUNT`

STOREPATH="results/"

for i in $numbers ; 
do
    #start wireshark
    tshark -i $INT -nn -e frame.number -e frame.time_relative -e frame.time_delta -e frame.len -e ipv6.src -e ipv6.dst -e ipv6.plen -e tcp.len -e tcp.seq -e tcp.ack -e tcp.flags -e tcp.flags.syn -e tcp.flags.ack -e tcp.flags.reset -e tcp.flags.urg -e tcp.flags.push -e tcp.flags.fin -e tcp -e icmpv6.nd.ns.target_address -e icmpv6.nd.na.target_address -T fields -E header=y -E separator=, -E quote=d  > $STOREPATH/$count.csv &
    pid=$!
    sleep 1
   echo "+------------------------------------------------+"
   echo "| Test: $count   			 	 |"
   echo "+------------------------------------------------+"
   count=`expr $count + 1`
    #start ftp
    scp $FILE $USER@$HOST:
    sleep 1
    #end wireshark
    kill -HUP $pid
    sleep 1
done

#end progam
echo "+------------------------------------------------+"
echo "| DONE!	 				 	 |"
echo "+------------------------------------------------+"

exit 0
