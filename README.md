## Introduction

Takes your [Put.io](http://put.io) account and downloads the data to your server. It will then delete the file off of your account and do any post-process scripts that you have added.

At the moment, this project has not yet been finished.

## Prerequisites

You'll need to have a [Put.io](http://put.io) account and you will need to have an OAuth token from an application you have created. You can obtain one [here](https://put.io/v2/oauth2/register).

## Install

A simple clone would do.

    git clone https://github.com/sjlu/Put.io-Manager.git putio
    
You then want to edit [application/config/putio.php](https://github.com/sjlu/Put.io-Manager/blob/master/application/config/putio.php). Details on configuration values are displayed in the file itself.

After, you'd probably want to get this running. It's a simple cron you want to add.

    08 * * * * php /usr/share/putio/index.php cron sync
    
