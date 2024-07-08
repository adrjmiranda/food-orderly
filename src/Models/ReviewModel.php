<?php

namespace Src\Models;

class ReviewModel extends Model
{
  const TABLE = "reviews";

  public int $id;
  public int $score;
  public int $user_id;
  public int $dish_id;
  public string $created_at;
  public string $updated_at;

  public function __construct()
  {
    parent::__construct(self::TABLE);
  }
}