<?php

namespace src\Http\Controllers;

use core\AbstractClasses\Controller;
use Exception;
use src\Repositories\UserRepository;

class UserController extends Controller
{
  /**
   * Return all users in JSON-format
   * @throws Exception
   */
  public function index()
  {
    $users = new UserRepository();
    $data = $users->get();
    $this->response->sendResponse("ok", 200, $data);
  }

  /**
   * Return user with selected id in JSON-format
   * @param $params
   * @throws Exception
   */
  public function show($params)
  {
    $user = new UserRepository();
    $data = $user->find($params, 'id');
    $this->response->sendResponse("ok", 200, $data);
  }

  /**
   * Create user
   * Accept JSON-format only as POST-params
   * @throws Exception
   */
  public function store()
  {
    $user = new UserRepository();
    $user->create($this->request->input());
    $this->response->sendResponse("ok", 201);
  }

  /**
   * Update user
   * Accept JSON-format only as POST-params
   * @param $params
   * @throws Exception
   */
  public function update($params)
  {
    $user = new UserRepository();
    $user->update($params, $this->request->input());
    $this->response->sendResponse("ok", 202);
  }

  /**
   * Delete user
   * @param $params
   */
  public function delete($params)
  {
    $user = new UserRepository();
    $user->delete($params);
    $this->response->sendResponse("ok", 202);
  }
}
