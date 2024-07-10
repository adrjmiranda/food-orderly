<?php

namespace Src\Config\Validations;

use Src\Models\CategoryModel;

class DishValidate
{
  const IMAGE_MAX_SIZE = 2097152; // 2 MB in bytes
  const ALLOWED_IMAGE_EXTENSIONS = ["image/jpeg", "image/png"];

  private function isValidImageExtension(string $extension): bool
  {
    return in_array(strtolower($extension), self::ALLOWED_IMAGE_EXTENSIONS);
  }

  private function isValidImageSize(int $size): bool
  {
    return $size <= self::IMAGE_MAX_SIZE;
  }

  private function isValidName(string $name): bool
  {
    $pattern = "/^[A-Za-zÀ-ÖØ-öø-ÿ0-9-\s]{1,255}$/";
    return preg_match($pattern, $name);
  }

  private function isValidDescription(string $description): bool
  {
    $pattern = "/^.{1,255}$/s";
    return preg_match($pattern, $description);
  }
  private function isValidPrice(string $price): bool
  {
    $pattern = "/^(?!0\.00$)(?!0)(?!.*\..*\.)\d+(\.\d{1,2})?$/";
    return preg_match($pattern, $price);
  }
  private function isValidCategory(int $id): bool
  {
    $entity = (new CategoryModel)->findOne("id", $id);
    return ($entity instanceof CategoryModel);
  }
  public function getErrors(array $data): array
  {
    $errors = [];

    foreach ($data as $key => $value) {
      switch ($key) {
        case "image_file":
          $size = $data["image_file"]["size"];
          $extension = $data["image_file"]["extension"];

          if (!$this->isValidImageExtension($extension)) {
            $error["image_file"] = "Only jpg, jpeg or png images";
          } else if (!$this->isValidImageSize($size)) {
            $error["image_file"] = "Only images up to " . self::IMAGE_MAX_SIZE . " bytes allowed";
          }


          break;

        case "name":
          if (!$this->isValidName($value)) {
            $error["name"] = "Only letters, numbers, spaces and hyphens";
          }

          break;

        case "description":
          if (!$this->isValidDescription($value)) {
            $error["description"] = "Only valid texts up to 255 characters";
          }

          break;

        case "price":
          if (!$this->isValidPrice($value)) {
            $error["price"] = "Only valid price values allowed";
          }

          break;

        case "category":
          if (!$this->isValidCategory($value)) {
            $error["category"] = "Invalid category";
          }

          break;
      }
    }

    return $errors;
  }
}


