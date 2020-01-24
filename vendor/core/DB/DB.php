<?php


namespace core\DB;

use Exception;

/**
 * Class DB
 * @package core
 */
class DB
{
  private static ?DB $instance = null;
  private static \PDO $connection;

  /**
   * DB constructor.
   * @throws Exception
   */
  private function __construct()
  {
    try {
      self::$connection = new \PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(\PDO::ATTR_PERSISTENT => true));
    }catch (\PDOException $e){
      throw new Exception('Connection to database is failed', 500);
    }
  }

  public function start()
  {
    return self::$connection;
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
