<?php

namespace Src\Models;

class CartItemModel extends Model
{
  const TABLE = "cart_items";

  public int $id;
  public float $amount;
  public int $cart_id;
  public int $dish_id;
  public string $created_at;
  public string $updated_at;

  public function __construct()
  {
    parent::__construct(self::TABLE);
  }
}