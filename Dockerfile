# Raspbian Jessie installation
FROM resin/rpi-raspbian:jessie

MAINTAINER Frickler24 <frickler24@frickler24.de>

RUN apt-get update && apt-get -y upgrade \
	&& apt-get -y install --no-install-recommends --no-install-suggests \
		php5-fpm php5-cgi php5-cli php5-gd php5-common \
		nginx \
		vim \
		net-tools \
	&& rm -rf /var/lib/apt/lists/*

# Forward request and error logs to docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
	&& ln -sf /dev/stderr /var/log/nginx/error.log

# Add neccessary files
ADD _etc_nginx_sites-available_default /etc/nginx/sites-available/default
ADD _var_www_html_test.php /var/www/html/test.php
ADD brot.php /var/www/html/brot.php
ADD mandel.php /var/www/html/mandel.php
ADD startfiles /tmp/startfiles

# Exposed ports HTTP(S)
EXPOSE 80 443

ENTRYPOINT sh /tmp/startfiles

CMD ["sh", "/tmp/startfiles"]
