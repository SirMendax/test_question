<?php


namespace src\Repositories;


use core\helpers\DateHelper;
use Exception;
use src\Models\Tarif;

/**
 * Class TarifRepository
 * @package src\Repositories
 */
class TarifRepository extends AbstractRepository
{
  public function getClassName(): string
  {
    return Tarif::class;
  }

  /**
   * @param array $params
   * @param array $columns
   * @return array
   * @throws Exception
   */
  public function getTarifsForGroup($params, array $columns) :array
  {
    $columns = implode(", ", $columns);
    $tarif_group_id = $this->getGroupId($this->getTarifId($params['user_id'], $params['service_id']));
    $sql = "SELECT $columns FROM " . $this->model->getTableName() . " WHERE tarif_group_id=:tarif_group_id";

    $stmt = $this->model->db::instance()->prepare($sql);
    $stmt->bindParam(':tarif_group_id', $tarif_group_id);
    $stmt->execute();
    $raw = $stmt->fetchAll(\PDO::FETCH_OBJ);

    $data = [
      'title' => $raw[0]->title,
      'link' => $raw[0]->link,
      'speed' => $raw[0]->speed,
      'tarifs' => array()
    ];

    foreach ($raw as $row) {
      unset($row->link);
      $row->new_payday = DateHelper::addPayPeriod($row->pay_period, new \Datetimezone('Europe/Moscow'), 'UO');
      $data['tarifs'][] = $row;
    }

    return $data;
  }

  /**
   * @param array $params
   * @param array $data
   * @return bool
   * @throws Exception
   */
  public function updateWithService(array $params, array $data) :bool
  {
    var_dump(1);
    $tarif_id = $this->getTarifId($params['user_id'], $params['service_id']);
    $values = implode(", ", array_map(fn($key) => $key .'=:' . $key, array_keys($data)));
    $sql = "UPDATE tarifs SET $values WHERE id=:id";
    $stmt = $this->model->db::instance()->prepare($sql);
    foreach ($data as $k => $v){
      $stmt->bindParam(':'.$k, $v);
    }
    $stmt->bindParam(':id', $tarif_id);
    return $stmt->execute();
  }

  /**
   * @param int $tarif_id
   * @return mixed
   */
  protected function getGroupId(int $tarif_id) :int
  {
    $sql = "SELECT tarif_group_id FROM tarifs WHERE id=:id";
    $stmt = $this->model->db::instance()->prepare($sql);
    $stmt->bindParam(':id', $tarif_id);
    $stmt->execute();
    $raw = $stmt->fetch(\PDO::FETCH_OBJ);
    return $raw->tarif_group_id;
  }

  /**
   * @param int $user_id
   * @param int $service_id
   * @return int
   * @throws Exception
   */
  protected function getTarifId(int $user_id, int $service_id) :int
  {
    $sql = "SELECT tarif_id FROM services WHERE id=:id AND user_id=:user_id";
    $stmt = $this->model->db::instance()->prepare($sql);
    $stmt->bindParam(':id', $service_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $raw = $stmt->fetch(\PDO::FETCH_OBJ);
    if(is_object($raw)){
      return $raw->tarif_id;
    }else{
      throw new Exception("error", 422);
    }
  }
}
