<?php


namespace core;

/**
 * Class Model
 * @package core
 */
abstract class Model
{
  /**
   * @var DB
   */
  public DB $db;

  /**
   * Model constructor.
   */
  public function __construct()
  {
    $this->db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
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
