<?php

namespace Src\Models;

use PDO;
use PDOException;
use Exception;
use Src\Config\Database\Connection;
use Src\Config\Logs\Logger;

class Model
{
  protected ?PDO $pdo;
  private string $tableName;
  protected static ?Logger $logger = null;

  public function __construct(string $tableName)
  {
    $this->tableName = $tableName;
    self::$pdo = Connection::get();

    if (is_null(self::$logger)) {
      self::$logger = new Logger;
    }
  }

  protected function handleException(string $exceptionMessage): void
  {
    self::$logger->error($exceptionMessage);
    throw new Exception("Server Error", 500);
  }

  public function all(string $ordering = 'DESC', int $limit = 0): ?array
  {
    $query = "SELECT * FROM $this->tableName ORDER BY $ordering";

    if ($limit > 0) {
      $query .= " LIMIT $limit";
    }

    try {
      $stmt = self::$pdo->prepare($query);
      $stmt->execute();

      return $stmt->fetchAll();
    } catch (PDOException $pDOException) {
      $this->handleException($pDOException->getMessage());
    }
  }
}