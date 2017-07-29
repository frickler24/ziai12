verteil:
	./verteil.sh Andreas
	./verteil.sh Heike
	./verteil.sh Axel
	./verteil.sh Bettina
	./verteil.sh Peter
	./verteil.sh Thomas
	./verteil.sh Thommy
	./verteil.sh Friedi
	./verteil.sh Mario

eb:
	cp mandel.php brot.php eb/.
	(cd eb/.; ~lutz/.local/bin/eb deploy)

