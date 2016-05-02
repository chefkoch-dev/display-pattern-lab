#!/bin/bash

set -e

docker run -v $(pwd):/app dr.chefkoch.net/display-pattern-lab-dev npm install
docker run -v $(pwd):/app dr.chefkoch.net/display-pattern-lab-dev composer install
docker run -v $(pwd)/vendor/chefkoch/display-patterns:/app dr.chefkoch.net/display-pattern-lab-dev npm install
