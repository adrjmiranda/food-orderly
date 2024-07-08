<?php

namespace Src\Http;

use Exception;

define("GET", "GET");
define("POST", "POST");
define("PUT", "PUT");
define("DELETE", "DELETE");
define("OPTIONS", "OPTIONS");

class Router
{
  const PARAMS_PATTERN = "/\{([^}]*)\}/";
  const PARAM_NAME_PATTERN = "/^[a-z]+(?:_[a-z]+)*$/";
  const URL_STATIC_PARTS_PATTERN = "/^[a-z]+(?:-[a-z]+)*$/";

  private array $patternList = [
    '%d' => '/^[1-9][0-9]*$/',
    '%c' => '/^[a-zA-Z]+$/',
    '%s' => '/^[a-zA-Z\-]+$/',
    '?d' => '/^([1-9][0-9]*)*$/',
    '?c' => '/^[a-zA-Z]*$/',
    '?s' => '/^[a-zA-Z\-]*$/'
  ];

  private string $baseUrl;
  private Request $request;
  private Response $response;
  private array $staticRoutes;
  private array $dynamicRoutes;
  private array $params;

  public function __construct(string $baseUrl)
  {
    $this->baseUrl = $baseUrl;

    $this->request = new Request;
    $this->response = new Response;

    $this->staticRoutes = [];
    $this->dynamicRoutes = [];

    $this->params = [];
  }

  private function httpMethodIsEnabled(string $httpMethod)
  {
    $methods = [
      GET,
      POST,
      PUT,
      DELETE,
      OPTIONS
    ];

    return in_array($httpMethod, $methods);
  }

  private function getController(string $namespace)
  {
    $controller = explode("@", $namespace)[0];

    if (!class_exists($controller)) {
      throw new Exception("Server Error", 500);
    }

    return $controller;
  }

  private function getAction(string $namespace)
  {
    [$controller, $action] = explode("@", $namespace);

    if (!method_exists($controller, $action)) {
      throw new Exception("Server Error", 500);
    }

    return $action;
  }

  private function routeHasAlreadyBeenAdded(string $httpMethod, string $staticPart)
  {
    return isset($this->staticRoutes[$httpMethod][$staticPart]) || isset($this->dynamicRoutes[$httpMethod][$staticPart]);
  }

  private function addStaticRoute(string $httpMethod, string $uri, string $controller, string $action, array $middlewares = [])
  {
    $staticPart = $this->handlesStaticPartFormat($uri);

    if ($this->routeHasAlreadyBeenAdded($httpMethod, $staticPart)) {
      throw new Exception("Server Error", 500);
    }

    $this->staticRoutes[$httpMethod][$staticPart] = [
      'controller_namespace' => $controller,
      'action' => $action,
      'middlewares' => $middlewares
    ];
  }

  private function handlesDynamicParameterFormat(array $parts)
  {
    $paramList = [];

    $nonMandatoryParameterAlreadyAdded = false;

    foreach ($parts as $value) {
      [$name, $patternKey] = explode(':', $value);

      if (!isset($name) || !isset($patternKey)) {
        throw new Exception("Server Error", 500);
      }

      $name = trim($name);
      $patternKey = trim($patternKey);

      if (strpos($patternKey, "?") !== false) {
        $nonMandatoryParameterAlreadyAdded = true;
      }

      if (strpos($patternKey, "%") !== false && $nonMandatoryParameterAlreadyAdded) {
        throw new Exception("Server Error", 500);
      }

      if (!preg_match(Router::PARAM_NAME_PATTERN, $name)) {
        throw new Exception("Server Error", 500);
      }

      if (!in_array($patternKey, array_keys($this->patternList))) {
        throw new Exception("Server Error", 500);
      }

      $paramList[] = "{" . $name . ":" . $patternKey . "}";
    }

    return $paramList;
  }

  private function getUriDynamicPart(string $uri)
  {
    preg_match_all(Router::PARAMS_PATTERN, $uri, $matches);
    $paramList = $this->handlesDynamicParameterFormat($matches[1]);
    $dynamicPart = '/' . implode('/', $paramList);

    return $dynamicPart;
  }

  private function handlesStaticPartFormat(string $staticPart)
  {
    $parts = explode('/', $staticPart);
    $parts = array_filter($parts, fn($n) => $n !== "");

    $partsList = [];

    if (!empty($parts)) {
      foreach ($parts as $value) {
        if (!preg_match(Router::URL_STATIC_PARTS_PATTERN, $value)) {
          throw new Exception("Server Error", 500);
        }

        $partsList[] = $value;
      }
    }

    return "/" . implode('/', $partsList);
  }

  private function getUriStaticPart(string $uri)
  {
    preg_match_all(Router::PARAMS_PATTERN, $uri, $matches);
    $dynamicPart = '/' . implode('/', $matches[0]);
    $staticPart = str_replace($dynamicPart, '', $uri);
    $staticPart = $this->handlesStaticPartFormat($staticPart);

    return $staticPart;
  }

  private function addDynamicRoute(string $httpMethod, string $uri, string $controller, string $action, array $middlewares = [])
  {
    $dynamicPart = $this->getUriDynamicPart($uri);
    $staticPart = $this->getUriStaticPart($uri);

    if ($this->routeHasAlreadyBeenAdded($httpMethod, $staticPart)) {
      throw new Exception("Server Error", 500);
    }

    $this->dynamicRoutes[$httpMethod][$staticPart] = [
      'controller_namespace' => $controller,
      'action' => $action,
      'dynamic_part' => $dynamicPart,
      'middlewares' => $middlewares
    ];
  }

  private function handleCompleteUri(string $uri)
  {
    $parts = explode('/', $uri);
    $newParts = [];

    if (!empty($parts)) {
      foreach ($parts as $value) {
        $value = trim($value);
        $newParts[] = $value;
      }
    }

    return implode('/', $newParts);
  }

  private function addRoute(string $httpMethod, string $uri, string $controller, string $action, array $middlewares = [])
  {
    $uri = $this->handleCompleteUri($uri);

    if (preg_match(Router::PARAMS_PATTERN, $uri)) {
      $this->addDynamicRoute($httpMethod, $uri, $controller, $action, $middlewares);
    } else {
      $this->addStaticRoute($httpMethod, $uri, $controller, $action, $middlewares);
    }
  }

  public function get(string $uri, string $namespace, array $middlewares = [])
  {
    $controller = $this->getController($namespace);
    $action = $this->getAction($namespace);

    $this->addRoute(GET, $uri, $controller, $action, $middlewares);
  }
}