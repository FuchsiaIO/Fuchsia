<?php
  
//-------------------
// Load Fuchsia Libraries
//   This is for configuring any packages that you may install in the FRAMEWORK_PATH.
//   Generally these should follow the standard package autoloading.
//      See: https://github.com/FuchsiaIO/Package-Boilerplate
//   If it's a third-party application that follows a different package format,
//   you may specify the autoload file like so:
//     my_package => array('autoload' => 'my_autoloader.php')
//
//   In its most basic form, Fuchsia only requires the Action Controller and Action Dispatch packages.
//   Active Record autoloading is handled in the framework_path/framework.php
//
$packages = array(
  'action_controller',
  'action_dispatch',
  'active_support'
);