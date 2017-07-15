#!/bin/bash
set +ex

# Copy all relevant parts to the test nodes thomas-kiste and friedis-kiste

scp $(ls -1t | head -10) pi@friedis-kiste:ziai12/.
ssh pi@friedis-kiste sh -c "pwd && cd ~/ziai12 && pwd && docker build -f Dockerfile.nginx -t mandel . && docker build -f Dockerfile.phpfpm -t fpmimage ."

scp $(ls -1t | head -10) pi@Thomas-kiste:ziai12/.
ssh pi@Thomas-kiste sh -c "pwd && cd ~/ziai12 && pwd && docker build -f Dockerfile.nginx -t mandel . && docker build -f Dockerfile.phpfpm -t fpmimage ."

