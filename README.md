## Introduction

Takes your [Put.io](http://put.io) account and downloads the data to your server. It will then delete the file off of your account and do any post-process scripts that you have added. So more or less, this is a sync tool.

## Prerequisites

You'll need to have a [Put.io](http://put.io) account and you will need to have an OAuth token from an application you have created. You can obtain one [here](https://put.io/v2/oauth2/register).

## Install

1. A simple clone would do.

        git clone https://github.com/sjlu/Put.io-Manager.git putio
    
2. You then want to edit [application/config/putio.php](https://github.com/sjlu/Put.io-Manager/blob/master/application/config/putio.php). Details on configuration values are displayed in the file itself.

3. After, you'd probably want to get this running. It's a simple cron you want to add.

        08 * * * * php /usr/share/putio/index.php cron sync
    
## Automation

You probably want to automate your downloads with [Put.io](http://put.io). To do so, you can use this awesome tool called [showRSS](http://showrss.karmorra.info/). Add the RSS feed to your account and it'll do the rest.

## Requests & Issues

Any requests or issues should go into the [issue tracker](https://github.com/sjlu/Put.io-Manager/issues). All suggestions are welcome as this is not a fully speced or completed project yet.

## License

MIT.
