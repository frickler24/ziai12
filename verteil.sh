#!/bin/bash
set +ex

# Copy all relevant parts to the given node and start building images

scp $(ls -1t | head -10) pi@$1:ziai12/.
ssh pi@$1 sh -c "pwd && cd ~/ziai12 && pwd && docker build -f Dockerfile.nginx -t mandel . && docker build -f Dockerfile.phpfpm -t fpmimage ."

