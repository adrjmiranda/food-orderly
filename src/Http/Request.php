<?php

namespace Src\Http;

use Src\Config\Logs\Logger;

class Request
{
  private string $uri;
  private array $headers;
  private string $httpMethod;
  private array $queryParams;
  private array $postVars;
  private array $files;
  private Logger $logger;

  public function __construct(Logger $logger)
  {
    $this->headers = $this->get_all_headers();
    $this->queryParams = $_GET ?? [];
    $this->postVars = $_POST ?? [];
    $this->uri = $this->getOnlyUri();
    $this->files = $_FILES ?? [];
    $this->httpMethod = $_SERVER["REQUEST_METHOD"] ?? "";

    $this->logger = $logger;
  }

  private function get_all_headers(): array
  {
    $headers = [];
    foreach ($_SERVER as $key => $value) {
      if (strpos($key, "HTTP_") === 0) {
        $headerName = str_replace("_", "-", strtolower(substr($key, 5)));
        $headers[$headerName] = $value;
      }
    }

    return $headers;
  }

  private function getOnlyUri(): string
  {
    $url = parse_url($_SERVER["REQUEST_URI"]);
    return $url["path"];
  }

  public function getUri(): string
  {
    return $this->uri;
  }

  public function getHeaders(): array
  {
    return $this->headers;
  }

  public function getHttpMethod(): string
  {
    return $this->httpMethod;
  }

  public function getQueryParams(): array
  {
    return $this->queryParams;
  }

  public function getPostVars(): array
  {
    return $this->postVars;
  }

  public function getFile(string $name)
  {
    return $this->files[$name] ?? null;
  }
}