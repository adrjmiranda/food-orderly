<?php

namespace Src\Controllers;

use Src\Config\Cache\Cached;
use Src\Config\Logs\Logger;

class Controller
{
  protected Logger $logger;
  protected Cached $cached;

  public function __construct()
  {
    $this->logger = new Logger;
    $this->cached = new Cached($this->logger);
  }
}