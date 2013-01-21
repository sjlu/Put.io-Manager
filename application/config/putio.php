<?php
/**
 * Put your Put.IO OAuth Token here.
 * It requires that you register an API
 * application through Put.io
 * You can find it at:
 * https://put.io/v2/oauth2/register
 */
$config['putio_key'] = 'QLGRUYAP';

/**
 * This is where we will put your
 * downloads, it will default to 
 * the root directory of the project.
 */
$config['putio_location'] = '';

/**
 * What do we run after when we
 * got your file?
 */
$config['putio_process'] = 'python /usr/share/sickbeard/autoProcessTV/sabToSickBeard.py'

?>
