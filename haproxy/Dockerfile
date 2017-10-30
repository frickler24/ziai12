FROM arm32v6/alpine

MAINTAINER Frickler24 <frickler24@frickler24.de>

# Als erstes mal HAProxy laden und installieren
RUN apk --no-cache add haproxy

COPY _etc_haproxy_haproxy.cfg /etc/haproxy/haproxy.cfg

# HAProxy hört auf Port 80 und 81m die Statistik geht über Port 9000
EXPOSE 80 81 9082

# Starte haproxy manuell, damit der Container bestehen bleibt
CMD /bin/sh -c "echo 'Starting HAProxy' && haproxy -f /etc/haproxy/haproxy.cfg -V && echo 'HAProxy stopped.'"

