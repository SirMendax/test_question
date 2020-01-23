<?php


namespace src\Repositories;
use core\helpers\DateHelper;
use Exception;
use src\Models\Service;

/**
 * Class ServiceRepository
 * @package src\Repositories
 */
class ServiceRepository extends AbstractRepository
{
  public function getClassName(): string
  {
    return Service::class;
  }

  /**
   * @param array $params
   * @param array $data
   * @return bool
   * @throws Exception
   */
  public function updateWithUser(array $params, array $data) :bool
  {
    $service_id = $params['service_id'];
    $user_id = $params['user_id'];
    $sql = "UPDATE " . $this->model->getTableName() . " SET tarif_id=:tarif_id, payday=:payday WHERE id=:service_id AND user_id=:user_id";
    $payday = $this->getPayday($data['tarif_id']);
    $stmt = $this->model->db->prepare($sql);
    $stmt->bindValue(':tarif_id', $data['tarif_id']);
    $stmt->bindValue(':payday', $payday);
    $stmt->bindParam(':service_id', $service_id);
    $stmt->bindParam(':user_id', $user_id);
    return $stmt->execute();
  }

  /**
   * @param array $data
   * @return bool
   * @throws Exception
   */
  public function createService(array $data) :bool
  {
    $payday = $this->getPayday($data['tarif_id']);
    $data['payday'] = $payday;
    $column = implode(", ", array_keys($data));
    $values = implode(", ", array_map(fn($word) => ':' . $word, array_keys($data)));
    $sql = "INSERT INTO " . $this->model->getTableName(). " ($column) VALUES ($values)";
    return $this->do($sql, $data);
  }

  /**
   * @param int $user_id
   * @param int $service_id
   * @return string
   * @throws Exception
   */
  protected function getTarif(int $user_id, int $service_id) :string
  {
    $sql = "SELECT tarif_id FROM services WHERE id=:id AND user_id=:user_id";
    $stmt = $this->model->db->prepare($sql);
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

  /**
   * @param int $tarif_id
   * @return string
   * @throws Exception
   */
  protected function getPayday(int $tarifId) :string
  {
    $sql = "SELECT pay_period FROM tarifs WHERE id=:id";
    $stmt = $this->model->db->prepare($sql);
    $stmt->bindValue(':id', $tarifId);
    $stmt->execute();
    $row = $stmt->fetch(\PDO::FETCH_OBJ);
    return DateHelper::addPayPeriod($row->pay_period, new \Datetimezone('Europe/Moscow'), 'Y-m-d');
  }

}
