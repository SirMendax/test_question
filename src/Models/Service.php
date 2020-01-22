<?php

namespace src\Models;

use core\Model;
use core\helpers\DateHelper;
use Exception;

/**
 * Class Service
 * @package src\Models
 */
class Service extends Model
{
  /**
   * @return string
   */
  public function getNameClass(): string
  {
    return __CLASS__;
  }
}
