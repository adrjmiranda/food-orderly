<?php

namespace Src\Controllers;

use Src\Config\Cache\Cached;
use Src\Config\Logs\Logger;

class Controller
{
  protected static ?Logger $logger = null;
  protected static ?Cached $cached = null;

  public function __construct()
  {
    if (is_null(self::$logger)) {
      self::$logger = new Logger;
    }

    if (is_null(self::$cached)) {
      self::$cached = new Cached(self::$logger);
    }
  }
}