<?php

namespace core;

use core\ServiceContainer\DIContainer;
use core\Exception\HandlerException;

class App
{
  private static DIContainer $container;

  public function __construct()
  {
    self::$container = DIContainer::instance();
    $this->getParams();
    new HandlerException(self::$container->get('request'), self::$container->get('response'));
    $router = new Router\Router(self::$container->get('request'));
    require_once ROUTES . '/routes.php';
    $router->run(self::$container->get('request'), self::$container->get('response'));
  }

  private static function getParams()
  {
    $services = include CONF . '/app.php';
    if(!empty($services)){
      foreach($services as $type => $collection){
        foreach ($collection as $key => $val){
          self::$container->set($key, $val, $type);
        }
      }
    }

  }
}
