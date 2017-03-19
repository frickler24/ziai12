# Raspbian Jessie installation
FROM resin/rpi-raspbian:jessie

# Maintainer
MAINTAINER Frickler24 <frickler24@frickler24.de>

RUN apt-get update && apt-get -y upgrade
RUN apt-get -y install php5-fpm php5-cgi php5-cli php5-common nginx vim net-tools

# Add neccessary files
ADD _etc_nginx_sites-available_default /etc/nginx/sites-available/default
ADD _var_www_html_test.php /var/www/html/test.php

# Exposed ports HTTP(S)
EXPOSE 80 443

RUN php5-fpm
RUN nginx

CMD bash

