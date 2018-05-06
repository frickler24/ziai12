#!/bin/bash

# Konfigurationsblock
NOOBS="NOOBS_v2.7.0"
# NOOBS="NOOBS_v2.8.1"

#### ENDE des Konfigurationsblocks

# Lösche vorhandene Partitionen auf einer 16GB-Karte und ierzeuge ein neues FAT32-FS.
# Anschließend installiere NOOBS neu darauf.

# Als erstes bestimme die Größe und das Device der Karte
parted --list | grep -C 3 15,9GB
FILESYS=$(parted --list | grep  15,9GB | grep Festplatte | cut -d" " -f 3 | sed 's/:$//')

# Ist es eine 16GB-Karte?
if [ ${FILESYS}x != "x" ] ; then
    echo "16GB-Karte gefunden auf $FILESYS"
    echo -n "Korrekt? Falls nicht, mit CTRL-C abbrechen: "
    FILESIZE="15,9G"
    read
else
    # Nein, ist es eine 8GB-Karte?
    FILESYS=$(parted --list | grep  7948MB | grep Festplatte | cut -d" " -f 3 | sed 's/:$//')
    if [ ${FILESYS}x != "x" ] ; then
        echo "8GB-Karte gefunden auf $FILESYS"
        echo -n "Korrekt? Falls nicht, mit CTRL-C abbrechen: "
        FILESIZE="7,9G"
        read
    else
        # Nein, auch nicht. Sicherheitshalber weg hier...
        echo "Kein valides Filesystem gefunden, parted --list lieferte folgendes zurück:"
        parted --list
        echo "Bitte Device direkt suchen und über parted und ggfs. dd neue Partition anlegen"
        echo "Terminiere."
        exit -1
    fi
fi

# Device ist identifiziert und die Größe bestimmt.
# Nun die vorhandenen Partitionen auf dem Device löschen und eine einzige Partition neu anlegen.
parted $FILESYS << __EOF__
print
rm 1
rm 2
print
mkpart primary FAT32 1049k ${FILESIZE}
name NOOBS_245
print
__EOF__

# Das Filesystem ist immer FAT32 für NOOBS
mkfs.msdos -F32 -I -v ${FILESYS}1
fsck.msdos -a -w -v ${FILESYS}1

# Das Filesystem ist neu und sollte jetzt vom OS erkannt werden
partprobe -s
sleep 1

# Versuche die neue leere Partition einzuhängen für das Kopieren
mount ${FILESYS}1 /mnt
mount | grep /mnt

echo -n "und jetzt wird kopiert: "
read

# Das eigentliche Copy geht schnell, aber die Kiste schreibt nur in die FS-Buffer.
# Die Karte darf erst herausgenommen werden, wenn das letzte Byte geschrieben ist.
# Der Buffer-Flush erfolgt wie gewohnt mit sync. Das kann dauern (mehrere Minuten)
(cd ~lutz/Projekte/ziai12/${NOOBS}/; tar cf - .) | (cd /mnt; tar --no-same-owner -xvf -)
echo
echo "Schreibe Dateisystempufferinhalte auf die Karte (sync disk)..."
sync
echo "Auswerfen der Partition"
umount /mnt
sync
echo
echo "Fertig. Blinkt die LED noch?"
