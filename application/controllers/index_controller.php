<?php
  
namespace Controllers;

class indexController extends \ActionController\Controller\Base
{
  public function index()
  {
    $this->respondTo( function($format) {
      $format->json = true;
      $format->xml = true;
      $format->html = true;
    });
  }
}