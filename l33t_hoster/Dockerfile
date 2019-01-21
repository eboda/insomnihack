FROM ubuntu:latest

ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get -y update
RUN apt-get -y install apache2 apt-transport-https curl php php-gd php-curl php-pclzip php-mbstring libapache2-mod-php vim-common unzip 


ADD flag/get_flag flag/flag /
RUN chmod 400 /flag && chmod +x,u+s /get_flag


ADD webroot /var/www/html/
RUN rm /var/www/html/index.html && mkdir /var/www/html/images
RUN chown -R root:root /var/www/html/
RUN chmod o+wx,o-r /var/www/html/images

RUN chmod -r /tmp

ADD 000-default.conf /etc/apache2/sites-enabled/000-default.conf
RUN sed -i '/^disable_functions/ s/$/exec,passthru,shell_exec,system,proc_open,popen,pcntl_exec,posix_mkfifo, pg_lo_import, dbmopen, dbase_open, popen, chgrp, chown, chmod, symlink,apache_setenv,define_syslog_variables, posix_getpwuid, posix_kill, posix_mkfifo, posix_setpgid, posix_setsid, posix_uname, proc_close, pclose, proc_nice, proc_terminate,curl_exec,curl_multi_exec,parse_ini_file,show_source,imap_open,fopen,copy,rename,readfile,readlink,tmpfile,tempnam,touch,link,file_put_contents,file,ftp_connect,ftp_ssl_connect,/' /etc/php/7.2/apache2/php.ini
RUN sed -i '/^disable_classes/ s/$/SplFileObject,SplFileInfo,SplTempFileObject,SessionHandler/' /etc/php/7.2/apache2/php.ini

# disable /server-status
RUN a2dismod status

CMD service apache2 start;  /bin/bash
