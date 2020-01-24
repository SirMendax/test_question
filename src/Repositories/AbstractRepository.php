<?php

namespace src\Repositories;

use core\AbstractClasses\Model;
use Exception;

/**
 * Class AbstractRepository
 * @package src\Repositories
 */
abstract class AbstractRepository
{
  /**
   * @var Model
   */
  protected Model $model;

  /**
   * @var string
   */
  protected string $className;

  /**
   * AbstractRepository constructor.
   */
  public function __construct()
  {
    $this->className = $this->getClassName();
    $this->model = new $this->className;
  }

  abstract protected function getClassName() :string;

  /**
   * @return array
   * @throws Exception
   */
  public function get() :array
  {
    $sql = "SELECT * FROM " . $this->model->getTableName();
    $stmt = $this->model->db->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
    if($res){
      return $res;
    }else{
      throw new Exception("Resource not found", 400);
    }
  }

  /**
   * @param array $params
   * @param string $column
   * @return object
   * @throws Exception
   */
  public function find(array $params, string $column) :object
  {
    $val = $params[$column];
    $sql = "SELECT * FROM " . $this->model->getTableName() . " WHERE " . $column . '=:' . $column;
    $stmt = $this->model->db->prepare($sql);
    $stmt->bindParam(":".$column, $val);
    $stmt->execute();
    $res = $stmt->fetch(\PDO::FETCH_OBJ);
    if($res){
      return $res;
    }else{
      throw new Exception("Resource not found", 404);
    }
  }

  /**
   * @param array $data
   * @return bool
   * @throws Exception
   */
  public function create(array $data) :bool
  {
    $column = implode(", ", array_keys($data));
    $values = implode(", ", array_map(fn($word) => ':' . $word, array_keys($data)));
    $sql = "INSERT INTO " . $this->model->getTableName(). " ($column) VALUES ($values)";
    return $this->do($sql, $data);
  }

  /**
   * @param array $params
   * @param array $data
   * @return bool
   * @throws Exception
   */
  public function update(array $params, array $data) :bool
  {
    $values = implode(", ", array_map(fn($key) => $key .'=:' . $key, array_keys($data)));
    $sql = "UPDATE " . $this->model->getTableName() . " SET $values WHERE id=:id";
    return $this->do($sql, $data, $params);
  }

  /**
   * @param array $params
   * @return bool
   */
  public function delete(array $params) :bool
  {
    $sql = "DELETE FROM " . $this->model->getTableName() . " WHERE id=:id";
    $stmt = $this->model->db->prepare($sql);
    $stmt->bindParam(':id', $params['id'], \PDO::PARAM_INT);
    return $stmt->execute();
  }

  /**
   * @param string $sql
   * @param array $params
   * @param array $data
   * @return bool
   * @throws Exception
   */
  protected function do(string $sql, array $data, ?array $params = null) :bool
  {
    $stmt = $this->model->db->prepare($sql);

    foreach ($data as $k => $v){
      $stmt->bindValue(':'.$k, $v,\PDO::PARAM_STR);
    }

    if($params !== null){
      $stmt->bindParam(':id', $params['id']);
    }

    $res = $stmt->execute();

    if($res){
      return $res;
    }else {
      throw new Exception("error", 500);
    }

  }
}
