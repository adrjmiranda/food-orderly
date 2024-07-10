<?php

namespace Src\Models;

class DishModel extends Model
{
  const TABLE = "dishes";

  public int $id;
  public string $name;
  public string $image_name;
  public string $description;
  public float $price;
  public int $category_id;
  public string $created_at;
  public string $updated_at;

  public function __construct()
  {
    parent::__construct(self::TABLE);
  }
}