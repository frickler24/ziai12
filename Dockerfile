# Raspbian Jessie installation
FROM resin/rpi-raspbian:jessie

# Maintainer
MAINTAINER Frickler24 <frickler24@frickler24.de>

RUN apt update && apt upgrade
RUN apt install nginx

# Add neccessary files
ADD _etc_nginx_sites-available_default /etc/nginx/sites-available/default
ADD _var_www_html_test.php /var/www/html/test.php

# Exposed ports HTTP(S)
EXPOSE 80 443

CMD bash

