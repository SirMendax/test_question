<?php


namespace core;

use PDO;

/**
 * Class Model
 * @package core
 */
abstract class Model
{
  /**
   * @var PDO
   */
  public PDO $db;

  /**
   * Model constructor.
   */
  public function __construct()
  {
    $this->db = DB::instance()->start();
  }

  /**
   * @return string
   */
  abstract protected function getNameClass() :string;

  /**
   * @return string
   */
  public function getTableName() :string
  {
    return lcfirst(substr(
        $this->getNameClass(),
        strrpos($this->getNameClass(),
          '\\')+1)) . 's';
  }

}
