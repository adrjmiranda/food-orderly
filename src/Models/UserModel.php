<?php

namespace Src\Models;

class UserModel extends Model
{
  const TABLE = "users";

  public int $id;
  public string $first_name;
  public string $last_name;
  public string $email;
  public string $password;
  public ?string $street;
  public ?string $number;
  public ?string $complement;
  public ?string $name_on_credit_card;
  public ?string $person_code;
  public ?string $card_number;
  public ?string $validity;
  public ?string $cvv;
  public string $created_at;
  public string $updated_at;

  public function __construct()
  {
    parent::__construct(self::TABLE);
  }
}