<?php
/**
 * Put your Put.IO OAuth Token here.
 * It requires that you register an API
 * application through Put.io
 * You can find it at:
 * https://put.io/v2/oauth2/register
 *
 * EX. 'PAYURGLP'
 */
$config['putio_key'] = 'QLGRUYAP';

/**
 * This is where we will put your
 * downloads, it will default to
 * the root directory of the project.
 *
 * EX. /var/www/putio/downloads
 */
$config['putio_location'] = '/var/www/putio/downloads/';

/**
 * This is where we look for torrent
 * files to upload to your putio
 * account.
 */
$config['blackhole'] = '/var/www/couchpotato/torrents/';

/**
 * What do we run after when we
 * got your file?
 *
 * EX. 'python /usr/share/sickbeard/autoProcessTV/sabToSickBeard.py'
 */
$config['putio_process'] = 'python /usr/share/sickbeard/autoProcessTV/sabToSickBeard.py';

/**
 * Where should we place movies?
 */
$config['movie_path'] = '/var/www/sabnzbd/downloads/complete/Movies/';

?>
