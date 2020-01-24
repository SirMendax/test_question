<?php

namespace src\Models;

use core\AbstractClasses\Model;

/**
 * Class User
 * @package src\Models
 */
class User extends Model
{
  /**
   * @return string
   */
  protected function getNameClass(): string
  {
    return __CLASS__;
  }
}
