#include <stdio.h>
#include <string.h>
#include <unistd.h>
 
int main (int ac, char **av) {
	FILE *datei;
	char c;
	unsigned long tmp;

	while (1) {
		tmp = 0;
		datei = fopen ("/dev/mmcblk0", "r");
		if (datei) {
			while (1) {
				fseek(datei, 4096, SEEK_CUR);
				if (!feof (datei)) {
					fread(&c, sizeof(char), 1, datei);
				} else {
					printf ("Got EOF ");
					break;
				}
				if (tmp++ % 10000 == 0) {
					printf ("Got %u.\n", tmp);
					usleep (500000);
				}
			}
			fclose (datei);
		} else break;
		printf ("Nächster Durchgang\n");
	}
	perror ("fopen");
	return 0;
}
