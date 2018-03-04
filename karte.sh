#!/bin/bash

# Lösche vorhandene Partitionen auf einer 16GB-Karte und ierzeuge ein neues FAT32-FS.
# Anschließend installiere NOOBS neu darauf.

parted --list | grep -C 3 15,9GB
FILESYS=$(parted --list | grep  15,9GB | grep Festplatte | cut -d" " -f 3 | sed 's/:$//')
echo "16GB-Karte gefunden auf $FILESYS"
echo -n "Korrekt? Falls nicht, mit CTRL-C abbrechen: "
read

parted $FILESYS << __EOF__
print
rm 1
rm 2
print
mkpart primary FAT32 1049k 15,9G
name NOOBS_245
print
__EOF__

mkfs.msdos -F32 -I -v ${FILESYS}1
fsck.msdos -a -w -v ${FILESYS}1
partprobe -s
sleep 1
mount ${FILESYS}1 /mnt
mount | grep /mnt

echo -n "und jetzt wird kopiert: "
read

(cd ~lutz/Projekte/ziai12/NOOBS_v2.4.5/; tar cf - .) | (cd /mnt; tar --no-same-owner -xvf -)
echo Now syncing disks:
sync
echo "Auswerfen der Partition"
umount /mnt
sync
echo
echo "Fertig. Blinkt die LED noch?"
