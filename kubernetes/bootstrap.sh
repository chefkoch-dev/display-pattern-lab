#!/usr/bin/env bash

K8S_SERVER=${K8S_SERVER:-"http://127.0.0.1:8080"}
K8S_SKIP_TLS_VERIFY=${K8S_SKIP_TLS_VERIFY:-"false"}
K8S_ENVIRONMENT=${K8S_ENVIRONMENT:-"dev"}

C_kubectl="kubectl \
    --insecure-skip-tls-verify=${K8S_SKIP_TLS_VERIFY} \
    --server=${K8S_SERVER} \
    --username=${K8S_USERNAME} \
    --password=${K8S_PASSWORD}"

# Check for required env variables
if [ -z ${K8S_NAMESPACE} ]
then
    echo "K8S_NAMESPACE not set"
    exit 1
fi
# Check for project env variable
if [ -z ${K8S_PROJECT} ]
then
    echo "K8S_PROJECT not set"
    exit 1
fi

# Check for namespace env variable
if [ -z ${IMAGE_TAG} ]
then
    echo "IMAGE_TAG not set"
    exit 1
fi

function ensure-namespace-exists {
    echo -n "looking up namespace '${K8S_NAMESPACE}'... "

    # Check for existance of namespace in cluster
    if ! ${C_kubectl} get namespaces ${K8S_NAMESPACE} > /dev/null 2>&1
    then
        # create namespace
        ./kubetpl.sh templates/${K8S_ENVIRONMENT}/namespace.yml | ${C_kubectl} create -f -
        echo "CREATED"
    else
        echo "FOUND"
    fi
}

function deploy-services {
    echo "looking up services ..."

    for svc in templates/${K8S_ENVIRONMENT}/svc/*-svc.yml
    do
        svc_name=$(basename ${svc} .yml)
        svc_instance=$(${C_kubectl} --namespace=${K8S_NAMESPACE} get svc -otemplate --template='{{ range $index, $item := .items }}{{if eq $index 0}}{{$item.metadata.name}}{{end}}{{end}}' -l name="${svc_name}" || true)

        if [ -z "$svc_instance" ]
        then
            echo "creating service ${svc_name}"
            ./kubetpl.sh ${svc} | ${C_kubectl} --namespace=${K8S_NAMESPACE} create -f -
        fi
    done
    echo "DONE"
}

function deploy-rcs {
    echo "looking up replication controllers ..."

    for rc in templates/${K8S_ENVIRONMENT}/rc/*-rc.yml
    do
        rc_name=$(basename ${rc} .yml)
        rc_instance=$(${C_kubectl} --namespace=${K8S_NAMESPACE} get rc -otemplate --template='{{ range $index, $item := .items }}{{if eq $index 0}}{{$item.metadata.name}}{{end}}{{end}}' -l name="${rc_name}" || true)

        if [ -n "$rc_instance" ]
        then
            rc_replicas=$(${C_kubectl} --namespace=${K8S_NAMESPACE} get rc -otemplate --template='{{ range $index, $item := .items }}{{if eq $index 0}}{{$item.status.replicas}}{{end}}{{end}}' -l name="${rc_name}" || true)

            if [ $rc_replicas == "1" ]
            then
                echo "refusing rolling-update on rc '${rc_name}' since it only has 1 replica"
            else
                echo "rolling update on ${rc_name}"
                ./kubetpl.sh ${rc} | ${C_kubectl} --namespace=${K8S_NAMESPACE} rolling-update --update-period="10s" ${rc_instance} -f -
            fi

        else
            echo "creating ${rc_name}"
            ./kubetpl.sh ${rc} | ${C_kubectl} --namespace=${K8S_NAMESPACE} create -f -
        fi
    done
}

# FIX: this function seems to return 0 if there are no pods found (yet)
function wait-for-deployment {
    retries=0
    timeout=300

    while [ $retries -lt $timeout ]
    do
        ready=1
        podStates=$(${C_kubectl} --namespace=${K8S_NAMESPACE} get po --no-headers | awk '{ print $2 }')

        # check if there are any pods found at all -> if not, deployment hasn't started yet
        podNum=$(echo $podStates | wc -w)
        if [ $podNum = 0 ]
        then
            ready=0
        fi

        while read -r line; do
            actual=$(echo $line | cut -d'/' -f 1)
            expected=$(echo $line | cut -d'/' -f 2)

            if [[ $expected > 0 && $actual < $expected ]]
            then
                ready=0
            fi
        done <<< "$podStates"

        if [ $ready = 1 ]
        then
            echo ""
            return 0
        fi

        sleep 1
        retries=$((retries+1))
        echo -n "."
    done

    return 1
}
