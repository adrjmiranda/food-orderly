<?php

namespace Src\Models;

use PDO;
use PDOException;
use Exception;
use Src\Config\Database\Connection;
use Src\Config\Logs\Logger;

class Model
{
  protected static ?PDO $pdo;
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

  public function all(string $ordering = "DESC", int $limit = 0): ?array
  {
    $query = "SELECT * FROM $this->tableName ORDER BY id $ordering";

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

  public function find(string $column, mixed $value, string $order = "DESC", int $limit = 0): ?array
  {
    $query = "SELECT * FROM $this->tableName WHERE $column = :$column ORDER BY id $order";

    if ($limit > 0) {
      $query .= " LIMIT $limit";
    }

    try {
      $stmt = self::$pdo->prepare($query);
      $stmt->bindValue(":$column", $value);
      $stmt->execute();

      return $stmt->fetchAll();
    } catch (PDOException $pDOException) {
      $this->handleException($pDOException->getMessage());
    }
  }

  public function findOne(string $column, mixed $value)
  {
    $query = "SELECT * FROM $this->tableName WHERE $column = :$column LIMIT 1";

    try {
      $stmt = self::$pdo->prepare($query);
      $stmt->bindValue(":$column", $value);
      $stmt->execute();

      return $stmt->fetchObject(get_called_class());
    } catch (PDOException $pDOException) {
      $this->handleException($pDOException->getMessage());
    }
  }

  public function findByText(array $fields, string $textColumn, string $text, string $order = "DESC"): ?array
  {
    $query = "SELECT ";

    foreach ($fields as $column) {
      $query .= "$column, ";
    }
    $query = substr($query, 0, -2);
    $query .= " FROM $this->tableName WHERE $textColumn LIKE :text ORDER BY id $order";

    try {
      $stmt = self::$pdo->prepare($query);
      $stmt->bindValue(":text", '%' . $text . '%', PDO::PARAM_STR);
      $stmt->execute();

      return $stmt->fetchAll();
    } catch (PDOException $pDOException) {
      $this->handleException($pDOException->getMessage());
    }
  }

  public function findSpecificFields(array $fields, string $order = "DESC", int $limit = 0): ?array
  {
    $query = "SELECT ";

    foreach ($fields as $column) {
      $query .= "$column, ";
    }
    $query = substr($query, 0, -2);
    $query .= " FROM $this->tableName ORDER BY id $order";

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

  public function findSpecificFieldsAndCondition(array $fields, string $specificColumn, string $condition, mixed $specificValue, string $order = "DESC", int $limit = 0, int $offset = 0): ?array
  {
    $query = "SELECT ";

    foreach ($fields as $column) {
      $query .= "$column, ";
    }
    $query = substr($query, 0, -2);
    $query .= "FROM $this->tableName";

    $query .= " WHERE $specificColumn $condition :$specificColumn ORDER BY id $order";

    if ($limit > 0) {
      $query .= " LIMIT $limit";
    }

    if ($offset > 0) {
      $query .= " OFFSET $offset";
    }

    try {
      $stmt = self::$pdo->prepare($query);
      $stmt->bindValue(":$specificColumn", $specificValue);
      $stmt->execute();

      return $stmt->fetchAll();
    } catch (PDOException $pDOException) {
      $this->handleException($pDOException->getMessage());
    }
  }

  private function removeUselessKeysInStore(array $data): array
  {
    foreach ($data as $key => $value) {
      if (strpos($key, "Src\Models") !== false || $key === "id") {
        unset($data[$key]);
      }

      if (strpos($key, "pdo") !== false) {
        unset($data[$key]);
      }
    }

    return $data;
  }

  private function removeUselessKeysInUpdate(array $data): array
  {
    foreach ($data as $key => $value) {
      if (strpos($key, "Src\Models") !== false) {
        unset($data[$key]);
      }

      if (strpos($key, "pdo") !== false) {
        unset($data[$key]);
      }
    }

    return $data;
  }

  public function store()
  {
    $data = (array) $this;

    $data = $this->removeUselessKeysInStore($data);

    $columns = array_keys($data);

    $query = "INSERT INTO $this->tableName (";
    foreach ($columns as $column) {
      $query .= "$column, ";
    }
    $query = substr($query, 0, -2);
    $query .= ") VALUES (";

    foreach ($columns as $column) {
      $query .= ":$column, ";
    }
    $query = substr($query, 0, -2);
    $query .= ")";

    try {
      $stmt = self::$pdo->prepare($query);
      foreach ($data as $column => $value) {
        $stmt->bindValue(":$column", $value);
      }

      $stmt->execute();

      return self::$pdo->lastInsertId();
    } catch (PDOException $pDOException) {
      $this->handleException($pDOException->getMessage());
    }
  }

  public function update(): ?bool
  {
    $data = (array) $this;

    $data = $this->removeUselessKeysInUpdate($data);

    $columns = array_keys($data);

    $query = "UPDATE $this->tableName SET ";
    foreach ($columns as $column) {
      if ($column !== "id") {
        $query .= "$column = :$column, ";
      }
    }
    $query = substr($query, 0, -2);
    $query .= " WHERE id = :id";

    try {
      $stmt = self::$pdo->prepare($query);
      foreach ($data as $column => $value) {
        if ($column !== "id") {
          $stmt->bindValue(":$column", $value);
        }
      }
      $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);

      return $stmt->execute();
    } catch (PDOException $pDOException) {
      $this->handleException($pDOException->getMessage());
    }
  }

  public function delete(): ?bool
  {
    $data = (array) $this;

    try {
      $id = $data["id"];

      $query = "DELETE FROM $this->tableName WHERE id = :id";

      $stmt = self::$pdo->prepare($query);
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);

      return $stmt->execute();
    } catch (PDOException $pDOException) {
      $this->handleException($pDOException->getMessage());
    }
  }
}