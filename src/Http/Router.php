<?php

namespace Src\Http;

class Router
{
  const PARAMS_PATTERN = '/\{([^}]*)\}/';

  private string $baseUrl;
  private Request $request;
  private Response $response;
  private array $staticRoutes;
  private array $dynamicRoutes;
  private array $params;

  public function __construct()
  {
    $this->request = new Request;
    $this->response = new Response;

    $this->staticRoutes = [];
    $this->dynamicRoutes = [];

    $this->params = [];
  }
}