#!/bin/bash

exec docker run -ti --rm -p 8080:8080 -p 3001:3001 -v $(pwd):$(pwd) -w $(pwd) dr.chefkoch.net/display-pattern-lab node_modules/.bin/gulp
