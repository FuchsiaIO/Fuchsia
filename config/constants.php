<?php
  
/*
 * Base Path relative to public_html/index.hh
 * BASE_PATH provides the fundamental basis to autoloading classes
 * used in the Rime namespace as well as user-defined controllers, models,
 * and views.
 */
define('FUCHSIA_ROOT_PATH', dirname(dirname(__FILE__)));

/*
 * Dev Mode
 * Provides additional debugging and logs
 */
define('DEV_MODE', true);

/*
 * Use Active Record
 * Load active record library
 */
define('USE_ACTIVE_RECORD', true);

/*
 * Default Template
 * The default template
 */
define('DEFAULT_TEMPLATE','master');

/*
 * Framework Path
 * The location of the framework libraries
 */
define('FRAMEWORK_PATH', FUCHSIA_ROOT_PATH.'/fuchsia');

/*
 * Application Path Configs
 * Locations of application-based directories
 */
define('APPLICATION_PATH', FUCHSIA_ROOT_PATH.'/application');
define('CACHE_PATH', APPLICATION_PATH.'/cache');
define('LOG_PATH', FUCHSIA_ROOT_PATH.'/log');
define('CONFIG_PATH', FUCHSIA_ROOT_PATH.'/config');
define('VIEW_PATH', APPLICATION_PATH.'/views');
define('TEMPLATE_PATH',APPLICATION_PATH.'/views');
define('MODEL_PATH', APPLICATION_PATH.'/models');