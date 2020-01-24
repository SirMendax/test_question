<?php


namespace core\Router;


use core\Http\Request;
use core\Http\Response;
use Exception;

/**
 * Class Router
 * @package core
 */
class Router
{
  /**
   * @var array
   */
  private array $router = [];

  /**
   * @var array
   */
  private array $matchRouter = [];

  /**
   * @var string
   */
  private string $url;

  /**
   * @var string
   */
  private string $httpMethod;

  /**
   * @var array
   */
  private array $params = [];

  /**
   * @param string $url
   * @param string $httpMethod
   */
  public function __construct(Request $request)
  {
    $this->url = rtrim($request->getUrl(), '/');
    $this->httpMethod = $request->getMethod();
  }

  /**
   * @param string $pattern
   * @param string $method
   * @throws Exception
   */
  public function get(string $pattern, string $method) :void
  {
    $this->addRoute("GET", $pattern, $method);
  }

  /**
   * @param string $pattern
   * @param string $method
   * @throws Exception
   */
  public function post(string $pattern, string $method) :void
  {
    $this->addRoute('POST', $pattern, $method);
  }

  /**
   * @param string $pattern
   * @param string $method
   * @throws Exception
   */
  public function put(string $pattern, string $method) :void
  {
    $this->addRoute('PUT', $pattern, $method);
  }

  /**
   * @param string $pattern
   * @param string $method
   * @throws Exception
   */
  public function delete(string $pattern, string $method) :void
  {
    $this->addRoute('DELETE', $pattern, $method);
  }

  /**
   * @param string $httpMethod
   * @param string $pattern
   * @param string $method
   * @throws Exception
   */
  public function addRoute(string $httpMethod, string $pattern, string $method) :void
  {
    array_push($this->router, new Route($httpMethod, $pattern, $method));
  }


  private function getMatchRoutersByRequestMethod() :void
  {
    foreach ($this->router as $value) {
      if (strtoupper($this->httpMethod) == $value->getHttpMethod())
        array_push($this->matchRouter, $value);
    }
  }

  /**
   * @param array $patterns
   */
  private function getMatchRoutersByPattern(array $patterns) :void
  {
    $this->matchRouter = [];
    foreach ($patterns as $value) {
      if ($this->dispatch($this->cleanUrl($this->url), $value->getPattern()))
        array_push($this->matchRouter, $value);
    }
  }

  /**
   * @param string $url
   * @param string $pattern
   * @return bool
   */
  public function dispatch(string $url, string $pattern) :bool
  {
    preg_match_all('@{[\w]+}@', $pattern, $params, PREG_PATTERN_ORDER);

    $patternAsRegex = preg_replace_callback('@{[\w]+}@', [$this, 'convertPatternToRegex'], $pattern);

    $patternAsRegex = '@^' . $patternAsRegex . '$@';
    $patternAsRegex = str_replace(array( '{', '}' ), '', $patternAsRegex);

    if (preg_match($patternAsRegex, $url, $paramsValue)) {
      foreach ($params[0] as $key => $value) {
        if ($paramsValue[str_replace(array( '{', '}' ), '', $value)]) {
          $this->setParams(str_replace(array( '{', '}' ), '', $value), urlencode($paramsValue[str_replace(array( '{', '}' ), '', $value)]));
        }
      }
      return true;
    }

    return false;
  }

  /**
   * @throws Exception
   */
  public function run(Request $request, Response $response)
  {
    $this->getMatchRoutersByRequestMethod();
    $this->getMatchRoutersByPattern($this->matchRouter);
    if (!$this->matchRouter || empty($this->matchRouter)) {
      throw new Exception("Route not found", 404);
    } else {
      return $this->getController($this->matchRouter[0]->getMethod(), $request, $response);
    }
  }

  /**
   * @param string $controller
   */
  private function getController(string $controller, Request $request, Response $response) :void
  {

    $arrWithController = explode('@', $controller);

    $controller = 'src\\Http\\Controllers\\' . $arrWithController[0];

    if(!class_exists($controller)){
      throw new Exception('Controller not found', 404);
    }
    $controller = new $controller($request, $response);
    $method = $arrWithController[1];

    if (!method_exists($controller, $method)) {
      throw new Exception('Action not found', 404);
    }

    $controller->$method($this->params);

  }


  /**
   * @param $key
   * @param $value
   */
  private function setParams($key, $value) :void
  {
    $this->params[$key] = $value;
  }

  /**
   * @param string $matches
   * @return string
   */
  private function convertPatternToRegex($matches) :string
  {
    $key = str_replace(':', '', $matches[0]);
    return '(?P<' . $key . '>[0-9-]+)';
  }

  /**
   * @param $url
   * @return string
   */
  protected function cleanUrl($url): string
  {
    return str_replace(['%20', ' '], '-', $url);
  }

}
