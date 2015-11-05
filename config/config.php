<?php

require_once 'constants.php';
require_once FUCHSIA_ROOT_PATH.'/fuchsia/framework.php';
require_once 'autoload.php';

if(USE_ACTIVE_RECORD)
  require_once 'database.php';
  
require_once 'routes.php';
require_once 'template_registry.php';
require_once 'view_registry.php';