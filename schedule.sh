#!/bin/bash

POD=$(kubectl get pods --namespace=tool-events -o jsonpath="{.items[0].metadata.name}")
kubectl exec -it $POD -- /usr/bin/php /data/project/events/src/php/artisan load:all
