<?php

function view_path($view){
  return VIEW_PATH.'/'.$view;
}

$viewMap = array_map("view_path", array(
	  'index.index' => 'index/index.haml.php',
	)
);