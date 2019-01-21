FROM ubuntu:latest
RUN apt-get update && apt-get -y install python3 python3-termcolor

RUN groupadd -g 1000 echolord && useradd -g echolord -u 1000 echolord -s /bin/shell

ADD flag /flag
ADD chal/get_flag /get_flag

RUN chown root:root /flag \
    && chown root:root /get_flag \
    && chmod 4555 /get_flag \
    && chmod 400 /flag 


ADD scripts/clean.sh /tmp/clean.sh
RUN bash /tmp/clean.sh && rm /tmp/clean.sh 
ADD chal/shell.py /bin/shell


CMD runuser -u echolord -g echolord /bin/shell
