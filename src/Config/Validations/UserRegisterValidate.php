<?php

namespace Src\Config\Validations;

use Src\Models\UserModel;

class UserRegisterValidate
{
  const FIRST_NAME_MAX_LEN = 255;
  const LAST_NAME_MAX_LEN = 255;
  const PASS_MIN_LEN = 8;
  const PASS_MAX_LEN = 20;

  private function isValidName(string $name): bool
  {
    $pattern = "/^(?!.*\s{2,})[A-Za-zÀ-ÿ]+(?: [A-Za-zÀ-ÿ]+)*$/";
    return preg_match($pattern, $name);
  }

  public function emailIsAlreadyRegistered(string $email): bool
  {
    $entity = (new UserModel)->findOne("email", $email) ?? null;
    return ($entity instanceof UserModel);
  }

  public function isValidEmail(string $email): bool
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  private function isValidPasword(string $password): bool
  {
    if (empty($password)) {
      return false;
    }

    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{" . self::PASS_MIN_LEN . "," . self::PASS_MAX_LEN . "}$/";
    return preg_match($pattern, $password);
  }

  public function getErrors(array $data): array
  {
    $errors = [];

    foreach ($data as $key => $value) {
      switch ($key) {
        case "first_name":
          if (!$this->isValidName($value)) {
            $errors["first_name"] = "Invalid first name";
          }
          break;

        case "last_name":
          if (!$this->isValidName($value)) {
            $errors["last_name"] = "Invalid last name";
          }
          break;

        case "email":
          if ($this->emailIsAlreadyRegistered($value)) {
            $errors["email"] = "This email is already registered";
          } elseif (!$this->isValidEmail($value)) {
            $errors["email"] = "Invalid e-mail";
          }

          break;

        case "password":
          if (!$this->isValidPasword($value)) {
            $errors["password"] = "Invalid password (allowed: letters, numbers and 8-20 characters)";
          }

          break;

        case "password_confirmation":
          $password = $value["password"];
          $passwordConfirmation = $value["password_confirmation"];

          if (!$this->isValidPasword($passwordConfirmation)) {
            $errors["password_confirmation"] = "Invalid password (allowed: letters, numbers and 8-20 characters)";
          } else if ($passwordConfirmation !== $password) {
            $errors["password_confirmation"] = "Incorrect password confirmation";
          }
          break;
      }
    }

    return $errors;
  }
}