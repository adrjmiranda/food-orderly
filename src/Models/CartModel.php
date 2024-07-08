<?php

namespace Src\Models;

class CartModel extends Model
{
  const TABLE = "cart";

  public int $id;
  public int $user_id;
  public string $created_at;
  public string $updated_at;

  public function __construct()
  {
    parent::__construct(self::TABLE);
  }
}