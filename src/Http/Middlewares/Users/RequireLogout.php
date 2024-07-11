<?php

namespace Src\Http\Middlewares\Users;

use Src\Config\Logs\Logger;
use Src\Http\Request;
use Src\Http\Response;
use Src\Config\Session\Store;

class RequireLogout
{
  private Logger $logger;

  public function __construct(Logger $logger)
  {
    $this->logger = $logger;
  }

  public function handle(Request $request, Response $response, array $params, callable $next)
  {
    if (Store::isLogged("user")) {
      $response->redirect("/");
    }

    return $next($request, $response, $params);
  }
}