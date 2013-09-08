#!/bin/bash

if [ $(pidof -x putio_sync.sh | wc -w) -gt 1 ]; then
   exit
fi

php index.php sync
