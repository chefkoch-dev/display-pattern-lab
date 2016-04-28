#!/bin/bash

set -e

docker build -t dr.chefkoch.net/display-pattern-lab docker/
docker run -v $(pwd):/app dr.chefkoch.net/display-pattern-lab npm install
docker run -v $(pwd):/app dr.chefkoch.net/display-pattern-lab composer install
docker run -v $(pwd)/vendor/chefkoch/display-patterns:/app dr.chefkoch.net/display-pattern-lab npm install
