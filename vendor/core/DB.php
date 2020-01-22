<?php


namespace core;

use Exception;

/**
 * Class DB
 * @package core
 */
class DB
{
  private static \PDO $instance;

  /**
   * DB constructor.
   * @param string $hostname
   * @param string $username
   * @param string $password
   * @param string $database
   * @param string $port
   * @throws Exception
   */
  public function __construct(string $hostname, string $username, string $password, string $database, string $port)
  {
    try {
      self::$instance = new \PDO("mysql:host=" . $hostname . ";port=" . $port . ";dbname=" . $database, $username, $password, array(\PDO::ATTR_PERSISTENT => true));
    }catch (\PDOException $e){
      throw new Exception('Connection to database is failed', 500);
    }
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
