<?php

if(USE_ACTIVE_RECORD)
{
  $packages['active_record'] = array(
    'autoload' => 'ActiveRecord.php'
  );
}

foreach( $packages as $key => $value )
{
  $package = $value;
  $autoload = 'autoload.php';
  if(is_array($value))
  {
    $package = $key;
    $autoload = $value['autoload'];
  }
  require_once FRAMEWORK_PATH.'/'.$package.'/'.$autoload;
}

