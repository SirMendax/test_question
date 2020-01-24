<?php


namespace core\AbstractClasses;

use core\Http\Request;
use core\Http\Response;

/**
 * Class Controller
 * @package core
 */
abstract class Controller
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
  public function __construct(Request $request, Response $response) {
    $this->request = $request;
    $this->response = $response;
  }
}
