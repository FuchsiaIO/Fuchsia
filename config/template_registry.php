<?php

$templateMap = array_map($view ==> TEMPLATE_PATH.'/'.$view,array(
  	'master' => 'master.php',
  	'error' => 'error.php',
  	'notfound' => '404.php'
	)
);