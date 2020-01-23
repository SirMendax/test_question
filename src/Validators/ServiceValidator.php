<?php

namespace src\Validators;

use Exception;
use src\Models\Tarif;
use src\Repositories\TarifRepository;

/**
 * Class ServiceValidator
 * @package src\Validators
 */
class ServiceValidator
{
  /**
   * @param array|null $data
   * @param Tarif $tarif
   * @return bool
   * @throws Exception
   */
  public static function validUpdate(?array $data, TarifRepository $tarif) :bool
  {
    if ($data === null || !is_array($data)) throw new Exception("error", 422);
    if(!key_exists('tarif_id', $data)) throw new Exception("error", 422);
    $params = ['id' => $data['tarif_id']];
    if(!$tarif->find($params, 'id')) throw new Exception("error", 422);
    return true;
  }
}
