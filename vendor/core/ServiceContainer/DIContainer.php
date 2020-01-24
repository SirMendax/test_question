<?php


namespace core\ServiceContainer;

use core\Exception\ServiceNotFoundException;
use core\Exception\ParameterNotFounException;

/**
 * Class DIContainer
 * @package core\ServiceContainer
 */
final class DIContainer
{
  private array $container = [];
  private static ?DIContainer $instance = null;

  private function __construct()
  {
    $this->container = [];
  }

  public function get($key)
  {
    foreach ($this->container as $type => $collection)
    {
      if(array_key_exists($key, $collection)) {
        if($type === 'singleton'){
          return $this->container[$type][$key]::instance();
        }else{
          return new $this->container[$type][$key];
        }
      }else{
        throw new ServiceNotFoundException('Service not found');
      }
    }
  }

  public function set($key, $val, $type)
  {
    $this->container[$type][$key] = $val;
  }

  public static function instance()
  {
    if(self::$instance === null)
    {
      self::$instance = new self;
    }
    return self::$instance;
  }

  private function __clone(){}
  private function __wakeup(){}

}
