#!/bin/bash
ANZAHL=${1:-100}

while true ; do {
	for (( a=0 ; a < $ANZAHL ; a++ )) ; do
		# curl -s -k https://raschef > /dev/null &
		(curl -s -k https://raschef/temp.png > /dev/null ; echo -n ".") &
		echo -n +
	done
	exit 0

	echo -n -
	for (( a=0 ; a < $ANZAHL ; a++ )) ; do
		wait -n
	done
	echo -n .
} ;
done
