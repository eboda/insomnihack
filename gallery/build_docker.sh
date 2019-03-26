#!/bin/bash
gcc  -o flag/get_flag flag/get_flag.c
docker build -t eboda/gallery .
