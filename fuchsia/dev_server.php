<?php
/*
 * This file configures the internal PHP webserver to route all non-asset requests through index.php
 * PHP 5.4 users and up only!
 *  Use the internal PHP server for development uses ONLY
 *
 *  How to use:
 *    php -S 192.168.1.104:8080 -t public_html/ fuchsia/dev_server.php
 *    Open your browser and see the Fuchsia welcome message.
*/
   
if (file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
 return false; // serve the requested resource as-is.
} else {
 include_once 'index.php';
}