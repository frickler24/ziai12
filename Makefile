
all:
	cp mandel.php brot.php eb/.
	(cd eb/.; ~lutz/.local/bin/eb deploy)

