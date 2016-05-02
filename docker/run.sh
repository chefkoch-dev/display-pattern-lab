#!/bin/bash

docker run -ti --rm -p 8181:8181 -p 3001:3001 -v $(pwd):$(pwd) -w $(pwd) dr.chefkoch.net/display-pattern-lab-dev node_modules/.bin/gulp "$@"
