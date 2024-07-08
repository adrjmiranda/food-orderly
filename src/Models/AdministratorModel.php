<?php

namespace Src\Models;

class AdministratorModel extends Model
{
  const TABLE = "administrators";

  public int $id;
  public string $first_name;
  public string $last_name;
  public string $email;
  public string $password;
  public string $created_at;
  public string $updated_at;

  public function __construct(
  ) {
    parent::__construct(self::TABLE);
  }
}