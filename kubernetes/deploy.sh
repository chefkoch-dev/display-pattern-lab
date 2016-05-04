#!/usr/bin/env bash

set -ex

pushd "$(dirname $0)" > /dev/null

. bootstrap.sh

ensure-namespace-exists
deploy-services
deploy-rcs

wait-for-deployment
exit $?
