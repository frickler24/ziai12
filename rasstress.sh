#!/bin/bash
ANZAHL=${2:-100}
TARGET=${1:-localhost}

while true ; do {
	for (( a=0 ; a < $ANZAHL ; a++ )) ; do
		(curl -s -k $TARGET > /dev/null ; echo -n ".") &
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
