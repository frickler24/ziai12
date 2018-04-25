cd

docker rmi -f $(docker image ls -q)
docker rm -f $(docker ps -aq)
sudo apt purge -y docker-ce

rm -rf ziai12
time git clone -b openTec --single-branch https://github.com/frickler24/ziai12


