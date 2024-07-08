<?php

namespace Src\Models;

class CommentModel extends Model
{
  const TABLE = "comments";

  public int $id;
  public int $user_id;
  public int $dish_id;
  public string $content;
  public string $created_at;
  public string $updated_at;

  public function __construct()
  {
    parent::__construct(self::TABLE);
  }
}