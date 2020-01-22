<?php
namespace src\Http\Handler;
use core\Request;
use core\Response;
use Exception;

/**
 * Class HandlerException
 * @package src\Http\Handler
 */

class HandlerException
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
   * HandlerException constructor.
   */
  public function __construct()
  {
    $this->request = $GLOBALS['request'];
    $this->response = $GLOBALS['response'];
    if(DEBUG === true){
      error_reporting(-1);
    }else{
      error_reporting(0);
    }
    set_exception_handler([$this, 'exceptionHandler']);
  }

  /**
   * @param Exception $error
   */
  public function exceptionHandler(Exception $error)
  {
    $this->log($error->getMessage(), $error->getFile(), $error->getLine());
    $this->show($error->getMessage(), $error->getCode());
  }

  /**
   * @param string $message
   * @param string $file
   * @param string $line
   */
  protected function log($message = '', $file = '', $line = '')
  {
    $message =
      "{" . date('Y-m-d H:i:s')
      . "} TEXT ERROR: {$message} ~ FILE ERROR ~ {$file} ~ " .
      "LINE ERROR: {$line} \n ================================================================================================================================= \n";
    error_log($message, 3, '../storage/errors.log');
  }

  /**
   * @param string $msg
   * @param int $code
   */
  protected function show(string $msg, $code = 404)
  {
    $this->response->sendResponse($msg, $code);
  }
}
