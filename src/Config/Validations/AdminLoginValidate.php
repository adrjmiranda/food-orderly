<?php

namespace Src\Config\Validations;

use Src\Models\AdministratorModel;

class AdminLoginValidate
{
  private function emailIsRegistered(string $email): bool
  {
    $entity = (new AdministratorModel)->findOne("email", $email);

    return ($entity instanceof AdministratorModel);
  }

  private function passwordIsCorrect(string $email, string $password): bool
  {
    $admin = (new AdministratorModel)->findOne("email", $email);

    if ($admin instanceof AdministratorModel) {
      return password_verify($password, $admin->password);
    }

    return false;
  }

  public function getErrors(array $data): array
  {
    $errors = [];

    foreach ($data as $key => $value) {
      switch ($key) {
        case "email":
          if (!$this->emailIsRegistered($value)) {
            $errors["email"] = "Email not registered";
          }

          break;

        case "password":
          $email = $value["email"];
          $password = $value["password"];

          if (!$this->passwordIsCorrect($email, $password)) {
            $errors["password"] = "Incorrect password";
          }

          break;
      }
    }

    return $errors;
  }
}