#!/bin/bash

docker build . -t consumer/supervisor
docker-compose up
