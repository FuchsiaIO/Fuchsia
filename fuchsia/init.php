<?php
  
  Logger::configure(CONFIG_PATH.'/log_config.xml');
  $logger = Logger::getLogger('standard');
  
  $register = \ActionController\Registry\Register::getInstance();
  $register->attach($viewMap, 'viewMap');
  $register->attach($templateMap, 'templateMap');
  
//-------------------
// Check Route Caching
  
	if(!DEV_MODE)
	{
		$routeCache = CACHE_PATH.'/routes.cache';

		if(file_exists($routeCache))
		{
			$routes = unserialize(file_get_contents($routeCache));
			$router->setRoutes($routes);			
		}
		else
		{
			require_once CONFIG_PATH.'/routes.php';
			$routes = $router->getRoutes();
			file_put_contents($routeCache, serialize($routes));			
		}
	}
	
//-------------------
// Parse the request URI, add a trailing slash if non-existant 
   	
	$_SERVER['REQUEST_URI'] = (substr($_SERVER['REQUEST_URI'],-1) == '/' && strlen($_SERVER['REQUEST_URI']) > 1) ? substr($_SERVER['REQUEST_URI'],0,-1) : $_SERVER['REQUEST_URI'];
	$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	$route = $router->match($path, $_SERVER);
  
//-------------------
// Check whether a route has been found 

  if ($route)
  {
    
    $logger->trace($route->method[0].' "'.$route->path.'"');
    $logger->trace('Configs: '.json_encode($route->params));
  
		$controllerName = $route->params['controller'];
		$actionName = $route->params['action'];
		$dir = isset($route->params['directory']) && $route->params['directory'] ? str_replace('/','\\',$route->params['directory'].'/') : ''; 
		 		
//-------------------
// If the controller name does not have a namespace
// load from the default Application namespace

		if( substr($controllerName,-1) != '\\' )
    {
      $controllerFile = '\\Controllers\\'.$dir.$controllerName.'Controller';
      $logger->trace('Loading Controller: '.$controllerFile);
      $controller = new $controllerFile();
      unset($controllerFile);
    }
    else
    {
      $controller = new BASE_PATH.$controllerName();
    }
    
    $params = array();
    
    if( preg_match_all('/{+(.*?)}/', $route->path, $getParams) )
    {
      foreach($getParams[1] as $match)
      {
        $params[$match] = $route->params[$match];
      }
      unset($getParams);
    }
    
    if(method_exists($controller, $actionName))
    {
      if(method_exists($controller, 'filter'))
        $controller->filter($actionName);
        
      $logger->trace('Executing Action: '.$actionName);
      $logger->trace('   => '.json_encode($params));
      call_user_func_array(array($controller,$actionName), $params);
    }
    else
    {
      $message = "Call to undefined action '".$actionName."' in class ".get_class($controller);
      $logger->fatal($message);
      throw new \Exception($message);
    }
//-------------------
// Make sure the controller can respond to the following formats
      
    if
    ( 
      ( method_exists($controller, 'canRespondTo') 
        && $controller->canRespondTo($route->params['format']) 
      )
      || 
      !$route->params['format'] 
    )
    {
      
      if(method_exists($controller, 'getRenderer'))
        $logger->trace('Valid Responses: '.json_encode($controller->getRenderer()->getData()));
        
      switch($route->params['format'])
      {
        
//-------------------
// JSON
        case '.json':
          header('Content-Type: application/json');
          echo json_encode($controller->getData(),JSON_PRETTY_PRINT);
          break;
          
//-------------------
// XML - Unsupported currently

        case '.xml':
          die('Unsupported');
          break;
          
//-------------------
// HTML

        case '.html':
          
          $controller->loadViewRegistries();
          $controller->view->addData((array)$controller->getData());

//-------------------
// Execute the requested action TODO: Add validation
          
          if(!$controller->view->getLayout())
          {
            $controller->view->setLayout(
              $route->params['template'] ? $route->params['template'] : 'master'
            );
            $logger->trace('Loading Template: '.$controller->view->getLayout());
          }
          
          if(is_bool($controller->getRenderer()->getData()['.html']))
          {
//-------------------
// HTML - fuchsia.default

            $viewName = $controllerName.'/'.$actionName;
            $path = VIEW_PATH.'/'.$dir;
            if( file_exists($path.$viewName.'.haml.php') )
              $viewName .= '.haml.php';
            else
              $viewName .= '.php';
              
            $controller->view->getViewRegistry()->set('fuchsia.default',$path.$viewName);
            $controller->view->setView('fuchsia.default');
            
            $logger->trace('Setting fuchsia.default: '.$viewName);
                      
          }
          else
          {
            
//-------------------
// HTML - specified route
            
            $logger->trace('Defined View: '.$controller->getRenderer()->getData()->get('.html'));
            
            $controller->view->setView(
              $controller->getRenderer()->getData()['.html']
            );
              
          }
          
          echo $controller->view->__invoke((array)$controller->getData());
          break;
          
//-------------------
// Custom return type, no type, or unknown specified  
        
        default:
          /*
          $actionName = str_replace('.', '', $route->params['format']);           
          if(method_exists('\Lib\Response\CustomResponse', $actionName))
            (new \Lib\Response\CustomResponse($controller))->$actionName();
          */
          break;
      }
      
    }
    else
    {
//-------------------
// Internal Error - Controller is unable to respond to the requested format
      $logger->trace('Unable to respond to: '.$route->params['format']);
      die('Unable to respond to: '.$route->params['format']);
    }
  }
  else
  {    
//-------------------
// 404 - Page Not Found
    $logger->trace('No Route Found: '.' "'.$_SERVER['REQUEST_URI'].'"');
    die('not found');
       
  }   