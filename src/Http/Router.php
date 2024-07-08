<?php

namespace Src\Http;

use Exception;
use Src\Config\Logs\Logger;
use Src\Http\Middlewares\Queue;

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
  private Logger $logger;

  public function __construct(string $baseUrl, Logger $logger)
  {
    $this->baseUrl = $baseUrl;
    $this->logger = $logger;

    $this->request = new Request($logger);
    $this->response = new Response($logger);

    $this->staticRoutes = [];
    $this->dynamicRoutes = [];
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
      $this->logger->error("Controller Namespace $namespace Does Not Exist");
      throw new Exception("Server Error", 500);
    }

    return $controller;
  }

  private function getAction(string $namespace)
  {
    [$controller, $action] = explode("@", $namespace);

    if (!method_exists($controller, $action)) {
      $this->logger->error("Function $action Does Not Exist In Controller Namespace $namespace");
      throw new Exception("Server Error", 500);
    }

    return $action;
  }

  private function itIsStaticRoute(string $httpMethod, string $staticPart)
  {
    return isset($this->staticRoutes[$httpMethod][$staticPart]);
  }

  private function itIsDynamicRoute(string $httpMethod, string $staticPart)
  {
    return isset($this->dynamicRoutes[$httpMethod][$staticPart]);
  }

  private function routeHasAlreadyBeenAdded(string $httpMethod, string $staticPart)
  {
    return $this->itIsStaticRoute($httpMethod, $staticPart) || $this->itIsDynamicRoute($httpMethod, $staticPart);
  }

  private function addStaticRoute(string $httpMethod, string $uri, string $controller, string $action, array $middlewares = [])
  {
    $staticPart = $this->handlesStaticPartFormat($uri);

    if ($this->routeHasAlreadyBeenAdded($httpMethod, $staticPart)) {
      $this->logger->error("Static Route $staticPart Has Already Been Added To The Route List");
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
        $this->logger->error("Dynamic Route Definition Format Is Incorrect. It Must Be {[param name]:[pattern key]}");
        throw new Exception("Server Error", 500);
      }

      $name = trim($name);
      $patternKey = trim($patternKey);

      if (strpos($patternKey, "?") !== false) {
        $nonMandatoryParameterAlreadyAdded = true;
      }

      if (strpos($patternKey, "%") !== false && $nonMandatoryParameterAlreadyAdded) {
        $this->logger->error("It Is Not Allowed To Define A Dynamic Route With A Mandatory Parameter After A Non-Mandatory Parameter");
        throw new Exception("Server Error", 500);
      }

      if (!preg_match(self::PARAM_NAME_PATTERN, $name)) {
        $this->logger->error("Parameter Name Format Is Incorrect");
        throw new Exception("Server Error", 500);
      }

      if (!in_array($patternKey, array_keys($this->patternList))) {
        $this->logger->error("Pattern Key Is Not Defined");
        throw new Exception("Server Error", 500);
      }

      $paramList[] = "{" . $name . ":" . $patternKey . "}";
    }

    return $paramList;
  }

  private function getUriDynamicPart(string $uri)
  {
    preg_match_all(self::PARAMS_PATTERN, $uri, $matches);
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
        if (!preg_match(self::URL_STATIC_PARTS_PATTERN, $value)) {
          $this->logger->error("Static Route Is Outside The Allowed Format");
          throw new Exception("Server Error", 500);
        }

        $partsList[] = $value;
      }
    }

    return "/" . implode('/', $partsList);
  }

  private function getUriStaticPart(string $uri)
  {
    preg_match_all(self::PARAMS_PATTERN, $uri, $matches);
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
      $this->logger->error("Static Route $staticPart Has Already Been Added To The Route List");
      throw new Exception("Server Error", 500);
    }

    $this->dynamicRoutes[$httpMethod][$staticPart] = [
      'controller_namespace' => $controller,
      'action' => $action,
      'dynamic_part' => $dynamicPart,
      'middlewares' => $middlewares
    ];

    uksort($this->dynamicRoutes[$httpMethod], function ($a, $b) {
      return strlen($b) - strlen($a);
    });
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

    if (preg_match(self::PARAMS_PATTERN, $uri)) {
      $this->addDynamicRoute($httpMethod, $uri, $controller, $action, $middlewares);
    } else {
      $this->addStaticRoute($httpMethod, $uri, $controller, $action, $middlewares);
    }
  }

  private function verifyAndGetMiddlewares(array $middlewares): ?array
  {
    foreach ($middlewares as $middleware) {
      if (!class_exists($middleware)) {
        $this->logger->error("Middleware Namespace $middleware Does Not Exist");
        throw new Exception("Server Error", 500);
      }
    }

    return $middlewares;
  }

  public function add(string $httpMethod, string $uri, string $namespace, array $middlewares = [])
  {
    if (!$this->httpMethodIsEnabled($httpMethod)) {
      $this->logger->error("HTTP $httpMethod Method Is Not Enabled");
      throw new Exception("Server Error", 500);
    }

    $controller = $this->getController($namespace);
    $action = $this->getAction($namespace);

    $middlewares = $this->verifyAndGetMiddlewares($middlewares);

    $this->addRoute($httpMethod, $uri, $controller, $action, $middlewares);
  }

  private function getDynamicRoute(string $httpMethod, string $uri)
  {
    foreach (array_keys($this->dynamicRoutes[$httpMethod]) as $value) {
      if (strpos($uri, $value) !== false) {
        return $value;
      }
    }

    return null;
  }

  private function getOnlyNonEmptyParts(string $path): array
  {
    $parts = explode('/', $path);
    $parts = array_filter($parts, fn($n) => $n !== "");

    return array_values($parts);
  }

  private function getParametersIfValid(string $paramsPart, string $dynamicPart)
  {
    $params = [];

    $paramsList = $this->getOnlyNonEmptyParts($paramsPart);
    $dynamicList = $this->getOnlyNonEmptyParts($dynamicPart);

    if (count($paramsList) > count($dynamicList)) {
      $this->logger->error("More Parameters Sent Than Expected In Dynamic Route Definition");
      throw new Exception("Route Not found", 404);
    }

    for ($i = 0; $i < count($dynamicList); $i++) {
      preg_match(self::PARAMS_PATTERN, $dynamicList[$i], $matches);
      [$name, $patternKey] = explode(':', $matches[1]);

      if (strpos($patternKey, "%") !== false) {
        if (!isset($paramsList[$i])) {
          $this->logger->error("Mandatory Parameter In Dynamic Route Not Received");
          throw new Exception("Route Not found", 404);
        }

        if (!preg_match($this->patternList[$patternKey], $paramsList[$i])) {
          $this->logger->error("Mandatory Parameter Value Does Not Conform To Expected Type In Dynamic Route");
          throw new Exception("Route Not found", 404);
        }
      }

      if (strpos($patternKey, "?") !== false) {
        if (isset($paramsList[$i])) {
          if (!preg_match($this->patternList[$patternKey], $paramsList[$i])) {
            $this->logger->error("Non-Required Parameter Value Does Not Conform To Expected Type In Dynamic Route");
            throw new Exception("Route Not found", 404);
          }
        }
      }

      $params[$name] = $paramsList[$i];
    }

    return $params;
  }

  public function run()
  {
    $uri = $this->request->getUri();
    $httpMethod = $this->request->getHttpMethod();

    try {
      if (!$this->httpMethodIsEnabled($httpMethod)) {
        $this->logger->error("HTTP $httpMethod Method Sent In Request Not Enabled");
        throw new Exception("Method $httpMethod Not Enabled", 400);
      }

      $params = [];

      if ($this->itIsStaticRoute($httpMethod, $uri)) {
        $controllerNamespace = $this->staticRoutes[$httpMethod][$uri]['controller_namespace'];
        $action = $this->staticRoutes[$httpMethod][$uri]['action'];

        $middlewares = $this->staticRoutes[$httpMethod][$uri]['middlewares'];
      } else {
        $staticPart = $this->getDynamicRoute($httpMethod, $uri);

        if (is_null($staticPart)) {
          $this->logger->error("Request On Route $uri Not Defined");
          throw new Exception("Route $uri Not found", 404);
        } else {
          $controllerNamespace = $this->dynamicRoutes[$httpMethod][$staticPart]['controller_namespace'];
          $action = $this->dynamicRoutes[$httpMethod][$staticPart]['action'];

          $middlewares = $this->dynamicRoutes[$httpMethod][$uri]['middlewares'];

          $paramsPart = str_replace($staticPart, '', $uri);

          $params = $this->getParametersIfValid($paramsPart, $this->dynamicRoutes[$httpMethod][$staticPart]['dynamic_part']);
        }
      }

      $queu = new Queue($controllerNamespace, $action, $middlewares, $this->logger);
      $queu->next($this->request, $this->response, $params);
    } catch (Exception $exception) {
      $this->response->send($exception->getMessage(), $exception->getCode());
    }
  }
}