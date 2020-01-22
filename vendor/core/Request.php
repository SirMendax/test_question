<?php

namespace core;

/**
 * Class Request
 * @package core
 */

class Request {

  /**
   * @var array
   */
  public array $request;

  /**
   * Request constructor.
   */
  public function __construct()
  {
    $this->request = $_REQUEST;
  }

  /**
   * @return array
   */
  public function input() :?array
  {
    $post = file_get_contents("php://input");
    if($post === '' || $post === null){
      return $request = null;
    }else{
      return $request = json_decode($post, true);
    }
  }

  /**
   * @param string $key
   * @return string
   */
  public function server(string $key = '') :string
  {
    return isset($_SERVER[strtoupper($key)]) ? $this->clean($_SERVER[strtoupper($key)]) : $this->clean($_SERVER);
  }

  /**
   * @return string
   */
  public function getMethod() :string
  {
    return strtoupper($this->server('REQUEST_METHOD'));
  }

  /**
   * @return string
   */
  public function getUrl() :string
  {
    return $this->server('REQUEST_URI');
  }

  /**
   * @param $data
   * @return string
   */
  private function clean($data) :string
  {
    if (is_array($data)) {
      foreach ($data as $key => $value) {
        unset($data[$key]);
        $data[$this->clean($key)] = $this->clean($value);
      }
    } else {
      $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
    }
    return $data;
  }
}
