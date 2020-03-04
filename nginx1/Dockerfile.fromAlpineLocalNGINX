FROM arm32v6/alpine:3.8

LABEL maintainer="frickler24@frickler24.de"

# Als erstes mal den nginx und das notwendige PHP-Geraffel laden und installieren
RUN apk --no-cache add php nginx php5-fpm php5-gd

# Verzeichnisse anlegen, falls noch nicht vorhanden
# Unter /run/nginx merkt sich der nginx seine Prozess-ID
# und unter /var/www/html wollen wir unsere HTML- und PHP-Files ablegen
RUN mkdir -p /run/nginx /var/www/html

# Das Config-File für nginx, damit er weiß, was wir von ihm wollen
COPY _etc_nginx_sites-available_default /etc/nginx/conf.d/default.conf

# Hier stehen ein paar Parameter für phpfpm,
# z.B. dass er über Port 9000 auf localhost erreichbar sein soll.
COPY _usr_local_etc_php-fpm.d_www.conf /etc/php5/php-fpm.conf

# Die maximale Laufzeit für php-Programme wird hierin gesetzt
COPY _etc_php5_php.ini /etc/php5/php.ini

# Eine HTML-Test-Datei (das ist die Standard nginx-Datei)
COPY _var_www_html_test.html /var/www/html/test.html

# Hier lesen wir php5-GD Parameter (Graphics develop)
# und PHP-Standard-Params, wenn wir nginx und phpfpm richtig konfiguriert haben
COPY _var_www_html_test.php /var/www/html/test.php

# Das Berechnen einer einzelnen Mandelbrot-Kachel
COPY mandel.php /var/www/html/mandel.php

# Das gesamte Brötchen berechnen (über mandel.php)
COPY brot.php /var/www/html/brot.php

# Nginx hört wie jeder Webserver auf HTTP über Port 80
EXPOSE 80

# Start phpfpm, dann nginx so, dass er im Vordergrund bleibt
CMD /bin/sh -c "php-fpm5 && echo 'Starting nginx' && nginx -g 'daemon off;' && echo 'nginx stopped.'"

