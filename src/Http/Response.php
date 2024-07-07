<?php

namespace Src\Http;

class Response
{
  private array $headers;
  private string $contentType;
  private int $httpCode;

  private function setContentType(string $contentType)
  {
    $this->contentType = $contentType;
    $this->setHeaders('Content-Type', $contentType);
  }

  private function setHeaders(string $key, mixed $value)
  {
    $this->headers[$key] = $value;
  }

  private function sendHeaders()
  {
    http_response_code($this->httpCode);

    foreach ($this->headers as $key => $value) {
      header($key . ': ' . $value);
    }
  }

  public function send(mixed $content, int $httpCode, string $contentType = 'text/html')
  {
    $this->setContentType($contentType);
    $this->httpCode = $httpCode;

    $this->sendHeaders();

    switch ($this->contentType) {
      case 'text/html':
        echo $content;
        exit;

      case 'application/json':
        echo json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
  }
}