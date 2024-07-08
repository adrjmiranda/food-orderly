<?php

namespace Src\Config\Database;

use PDO;
use PDOException;
use Exception;
use Src\Config\Logs\Logger;

class Connection
{
  private static ?PDO $pdo = null;

  public static function get(): ?PDO
  {
    if (is_null(self::$pdo)) {
      $dbHost = $_ENV['DB_HOST'] ?? '';
      $dbName = $_ENV['DB_NAME'] ?? '';
      $dbUser = $_ENV['DB_USER'] ?? '';
      $dbPass = $_ENV['DB_PASS'] ?? '';

      try {
        self::$pdo = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass);

        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
      } catch (PDOException $pDOException) {
        (new Logger)->error($pDOException->getMessage());
        throw new Exception("Server Error", 500);
      }
    }

    return self::$pdo;
  }
}