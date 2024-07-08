<?php

namespace Src\Models;

class CategoryModel extends Model
{
  const TABLE = "categories";

  public int $id;
  public string $created_at;
  public string $updated_at;

  public function __construct()
  {
    parent::__construct(self::TABLE);
  }
}