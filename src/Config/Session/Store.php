<?php

namespace Src\Config\Session;

use Exception;
use Src\Config\Logs\Logger;

class Store
{
  const USER_KEY = "user";
  const ADMIN_KEY = "admin";

  protected static ?Logger $logger = null;

  public function __construct()
  {

    if (self::$logger === null) {
      self::$logger = new Logger;
    }

    self::init();
  }

  public static function init(): void
  {
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_set_cookie_params([
        "lifetime" => 0,
        "path" => "/",
        "secure" => $_ENV["APPLICATION_STATUS"] === "production" ? true : false,
        "httponly" => true,
        "samesite" => "Strict"
      ]);

      session_start();

      self::$logger->info("Session Started");

      if (!isset($_SESSION["initialized"])) {
        session_regenerate_id(true);
        $_SESSION["initialized"] = true;
      }
    }
  }

  private static function getValidKey(string $key): ?string
  {
    if (!in_array($key, [self::USER_KEY, self::ADMIN_KEY])) {
      self::$logger->error("$key Session Key Not Enabled");
      throw new Exception("Server Error", 500);
    }

    return $key;
  }

  public static function set(string $key, array $data): void
  {
    self::init();

    try {
      $key = self::getValidKey($key);

      foreach ($data as $var => $value) {
        $_SESSION[$key][$var] = $value;
      }
    } catch (Exception $exception) {
      self::$logger->error($exception->getMessage());
      throw new Exception("Serve Error", 500);
    }
  }

  public static function logout(string $key): void
  {
    self::init();

    $key = self::getValidKey($key);

    unset($_SESSION[$key]);
  }

  public static function isLogged(string $key): bool
  {
    self::init();

    $key = self::getValidKey($key);

    return isset($_SESSION[$key]);
  }
}