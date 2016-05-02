#!/bin/bash

docker run -ti --rm -p 80:8080 -p 3001:3001 -v $(pwd):$(pwd) -w $(pwd) dr.chefkoch.net/display-pattern-lab-dev node_modules/.bin/gulp "$@"
