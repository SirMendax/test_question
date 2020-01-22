<?php


namespace src\Repositories;


use src\Models\User;

/**
 * Class UserRepository
 * @package src\Repositories
 */
class UserRepository extends AbstractRepository
{
  public function getClassName(): string
  {
    return User::class;
  }
}
