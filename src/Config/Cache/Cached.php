<?php

namespace Src\Config\Cache;

use Src\Config\Logs\Logger;

class Cached
{
  private static Logger $logger;
  private static string $filePath;

  public function __construct(Logger $logger)
  {
    self::$logger = $logger;
    self::$filePath = "/../../resources/cache/";
  }

  public function get(string $key)
  {
    $file = __DIR__ . self::$filePath . md5($key) . ".cache";

    if (file_exists($file)) {
      $data = unserialize(file_get_contents($file));

      if ($data["expiration"] > time()) {
        return $data["content"];
      } else {
        unlink($file);
      }
    }

    return false;
  }

  public function set(string $key, mixed $content, int $expiration)
  {
    $file = __DIR__ . self::$filePath . md5($key) . ".cache";

    $data = [
      "content" => $content,
      "expiration" => time() + $expiration
    ];

    file_put_contents($file, serialize($data));
  }

  public function clear(string $key)
  {
    $file = __DIR__ . self::$filePath . md5($key) . ".cache";

    if (file_exists($file)) {
      unlink($file);
    }
  }
}