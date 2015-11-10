<?php

function template_path($view){
  return TEMPLATE_PATH.'/'.$view;
}

$templateMap = array_map("template_path", array(
  	'master' => 'master.php',
  	'error' => 'error.php',
  	'notfound' => '404.php'
  )
);