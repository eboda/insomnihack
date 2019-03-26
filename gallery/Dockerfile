FROM ubuntu:latest
MAINTAINER eboda

ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get -y update
RUN apt-get -y install apache2 apt-transport-https curl php libapache2-mod-php vim-common unzip 


ADD flag/get_flag flag/flag /
RUN chmod 400 /flag && chmod +x,u+s /get_flag


ADD webroot /var/www/html/
RUN rm /var/www/html/index.html && mkdir /var/www/html/sandbox
RUN chown -R root:root /var/www/html/
RUN chmod o+wx,o-r /var/www/html/sandbox

RUN chmod -r /tmp

ADD 000-default.conf /etc/apache2/sites-enabled/000-default.conf
# disable /server-status
RUN a2dismod status

CMD service apache2 start;  /bin/bash
