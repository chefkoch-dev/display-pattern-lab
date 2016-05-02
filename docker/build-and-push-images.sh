#!/bin/bash

set -e

docker build -t dr.chefkoch.net/display-pattern-lab-dev docker/images/dev
docker push dr.chefkoch.net/display-pattern-lab-dev
