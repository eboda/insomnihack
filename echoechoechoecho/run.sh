#!/bin/bash
set -x
killall -9 socat
NAME=echoechoechoecho

screen -mS $NAME socat tcp4-l:1337,bind=0.0.0.0,reuseaddr,fork exec:./spawn_instance.sh
