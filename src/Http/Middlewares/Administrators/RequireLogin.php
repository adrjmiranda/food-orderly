<?php

namespace Src\Http\Middlewares\Administrators;

use Src\Config\Logs\Logger;
use Src\Http\Request;
use Src\Http\Response;
use Src\Config\Session\Store;

class RequireLogin
{
  private Logger $logger;

  public function __construct(Logger $logger)
  {
    $this->logger = $logger;
  }

  public function handle(Request $request, Response $response, array $params, callable $next)
  {
    if (!Store::isLogged("admin")) {
      $response->redirect("/admin/login");
    }

    return $next($request, $response, $params);
  }
}