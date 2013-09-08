#!/bin/bash

if [ $(pidof -x putio_sync.sh | wc -w) -gt 2 ]; then
   exit
fi

php index.php cron sync
