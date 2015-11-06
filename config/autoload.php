<?php

/*************************************************************************/
/* Autoload any third-party apps installed through composer.             */
/*************************************************************************/

require_once FUCHSIA_ROOT_PATH.'/vendor/autoload.php';

/*************************************************************************/
/* Autoload the Fuchsia Application when it's namespaces are called.     */
/*************************************************************************/
  
spl_autoload_register(function($class){
  $class = strtolower(preg_replace('/\B([A-Z])/', '_$1', $class ));
  $file = APPLICATION_PATH .
    implode( '', 
      array_map( 
        function($fragment) use ($class){
          return "/$fragment";
        }, explode( '\\', $class )
      )
    ).'.php';
    if(file_exists($file))
    {
      require_once $file;
    }
});