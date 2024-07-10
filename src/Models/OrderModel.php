<?php

namespace Src\Models;

class OrderModel extends Model
{
  const TABLE = "orders";

  public int $id;
  public float $amount;
  public string $status;
  public string $customers_first_name;
  public string $customers_last_name;
  public string $street;
  public string $number;
  public string $complement;
  public string $name_on_credit_card;
  public string $person_code;
  public string $card_number;
  public string $validity;
  public string $cvv;
  public int $user_id;
  public string $created_at;
  public string $updated_at;

  public function __construct()
  {
    parent::__construct(self::TABLE);
  }
}