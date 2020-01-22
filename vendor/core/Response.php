<?php


namespace core;

use core\helpers\ResponseStatus;

/**
 * Class Response
 * @package core
 */
class Response
{
  /**
   * @var array
   */
  protected array $headers = [];

  /**
   * @var array
   */
  protected array $status = [];

  /**
   * @var string
   */
  protected string $version;

  /**
   * Data for response
   */
  protected $content;

  /**
   * Response constructor.
   */
  public function __construct()
  {
    $this->setVersion('1.1');
    $this->status = ResponseStatus::getStatus();
  }

  /**
   * @param string $version
   */
  public function setVersion(string $version) :void
  {
    $this->version = $version;
  }

  /**
   * @param int $code
   * @return string
   */
  public function getStatusCodeText(int $code): string
  {
    return (string)isset($this->status[$code]) ? $this->status[$code] : 'unknown status';
  }

  /**
   * @param $header
   */
  public function setHeader(String $header) :void
  {
    $this->headers[] = $header;
  }

  /**
   * @param $content
   */
  protected function setContent($content) :void
  {
    $this->content = $content;
  }

  /**
   * @param int $statusCode
   * @return bool
   */
  public function isInvalid(int $statusCode): bool
  {
    return $statusCode < 100 || $statusCode >= 600;
  }

  protected function sendStatus($code) :void
  {
    if (!$this->isInvalid($code)) {
      $this->setHeader(sprintf('HTTP/1.1 ' . $code . ' %s', $this->getStatusCodeText($code)));
    }
  }

  /**
   * @param string $status
   * @param int $code
   * @param $data
   * @return Response
   */
  public function sendResponse(string $status, int $code, $data = null) :Response
  {
    $this->sendStatus($code);
    if ($data !== null) {
      $this->setContent($data);
      $output = json_encode([
        "result" => $status,
        "data" => $this->content
      ]);
    } else {
      $output = json_encode([
        'result' => $status
      ]);
    }

    if (!headers_sent()) {
      foreach ($this->headers as $header) {
        header($header, true);
      }
    }

    echo $output;

    return $this;
  }

}
