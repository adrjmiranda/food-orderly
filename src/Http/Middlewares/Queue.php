<?php

namespace Src\Http\Middlewares;

use Src\Config\Logs\Logger;
use Src\Http\Request;
use Src\Http\Response;

class Queue
{
  private string $controllerNamespace;
  private string $action;
  private array $middlewares;
  private Logger $logger;

  public function __construct(string $controllerNamespace, string $action, array $middlewares, Logger $logger)
  {
    $this->controllerNamespace = $controllerNamespace;
    $this->action = $action;
    $this->middlewares = $middlewares;

    $this->logger = $logger;
  }

  public function next(Request $request, Response $response, array $params)
  {
    if (empty($this->middlewares)) {
      $controller = new $this->controllerNamespace();
      $action = $this->action;

      return $controller->$action($request, $response, $params);
    }

    $middlewareNamespace = array_shift($this->middlewares);
    $queu = $this;
    $next = function ($request, $response, $params) use ($queu) {
      return $queu->next($request, $response, $params);
    };

    $middleware = new $middlewareNamespace($this->logger);
    return $middleware->handle($request, $response, $params, $next);
  }
}