<?php


namespace core;

/**
 * Class Controller
 * @package core
 */
class Controller
{
  /**
   * @var Request
   */
  public Request $request;

  /**
   * @var Response
   */
  public Response $response;

  /**
   * Controller constructor.
   */
  public function __construct() {
    $this->request = $GLOBALS['request'];
    $this->response = $GLOBALS['response'];
  }
}
