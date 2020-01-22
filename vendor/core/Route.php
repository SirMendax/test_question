<?php


namespace core;


use Exception;

/**
 * Class Route
 * @package core
 */
class Route
{
  /**
   * @var string
   */
  private string $httpMethod;

  /**
   * @var string
   */
  private string $pattern;

  /**
   * @var array
   */
  private array $httpMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTION'];

  /**
   * @var string
   */
  private string $method;

  /**
   * Route constructor.
   * @param string $httpMethod
   * @param string $pattern
   * @param string $method
   * @throws Exception
   */
  public function __construct(string $httpMethod, string $pattern, string $method)
  {
    $this->httpMethod = $this->validate(strtoupper($httpMethod));
    $this->pattern = $this->cleanUrl($pattern);
    $this->method = $method;
  }

  /**
   * @return string
   */
  public function getHttpMethod() :string
  {
    return $this->httpMethod;
  }

  /**
   * @return string
   */
  public function getPattern() :string
  {
    return $this->pattern;
  }

  /**
   * @return string
   */
  public function getMethod() :string
  {
    return $this->method;
  }

  /**
   * @param $url
   * @return string|string[]
   */
  protected function cleanUrl($url) :string
  {
    return str_replace(['%20', ' '], '-', $url);
  }

  /**
   * @param string $method
   * @return string
   * @throws Exception
   */
  private function validate(string $method) :string
  {
    if (in_array(strtoupper($method), $this->httpMethods)){
      return $method;
    }else{
      throw new Exception('Invalid Method Name', 500);
    }
  }
}
