<?php

function template_path($view){
  return TEMPLATE_PATH.'/'.$view;
}

$templateMap = array_map("template_path", array(
  	'master' => 'master.haml.php',
  	'error' => 'error.haml.php',
  	'notfound' => '404.haml.php'
  )
);