<?php
/*
 * This file configures the internal PHP webserver to route all non-asset requests through index.php
 * PHP 5.4 users and up only!
 *  Use the internal PHP server for development uses ONLY
 *
 *  How to use:
 *    php -S localhost:8080 -t public_html/ fuchsia/dev_server.php
 *    Open your browser and see the Fuchsia welcome message.
*/

require_once 'config/constants.php';

if (file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
 return false; // serve the requested resource as-is.
} else {
 require_once FUCHSIA_ROOT_PATH.'/public_html/index.php';
}