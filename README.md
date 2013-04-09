wireshark-data-test
===================

runs an SCP 'x' number of times, capturing packets from wireshark's command line tool tshark and writes packets individual csv files.

<h2>test.sh</h2>
Set some values in the file, to control what to you want to do. These include:

	HOST='hostname' //hostname of remote host
	USER='root'     //username for SCP
	PASSWD='f00bar' //password for SCP
	FILE='file.txt' //file we want transfer
	
	INT="em0"       //interface to listen for packets on
	
	TESTCOUNT=100   //how many tests we want to run
	
	STOREPATH="results/"  //folder to store results in

Filters are set on line 19 as per http://www.wireshark.org/docs/dfref/
When the script runs, results will be stored in the STOREPATH as x.csv where x is the current test number.

<h2>To run</h2>
simply call ./test.sh 
