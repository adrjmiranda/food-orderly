<?php

namespace Src\Controllers\Administrators;

use Src\Config\Validations\DishValidate;
use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;
use Src\Models\DishModel;

class DishController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function store(Request $request, Response $response, array $params)
  {
    $formData = $request->getPostVars();

    $imageFile = $request->getFile("image_file");

    $name = $formData["name"] ?? "";
    $description = $formData["description"] ?? "";
    $price = $formData["price"] ?? "";
    $category = (int) ($formData["category"] ?? "");

    $dataToBeEvaluated = [
      "image_file" => [
        "extension" => $imageFile["type"],
        "size" => $imageFile["size"]
      ],
      "name" => $name,
      "description" => $description,
      "price" => $price,
      "category" => $category
    ];

    $errors = (new DishValidate)->getErrors($dataToBeEvaluated);

    if (!empty($errors)) {
      return (new DashboardController)->index($request, $response, ["session" => "new-dish"], [
        "values" => $dataToBeEvaluated,
        "errors" => $errors
      ]);
    }

    if ($imageFile["error"] === UPLOAD_ERR_OK) {
      $imageDir = __DIR__ . "/../../../assets/img/dishes/";

      if (!is_dir($imageDir)) {
        mkdir($imageDir, 0755, true);
      }

      $imageName = bin2hex(random_bytes(48)) . ".jpg";

      $imageFilePath = $imageDir . $imageName;

      if (!move_uploaded_file($imageFile["tmp_name"], $imageFilePath)) {
        $errors["image_file"] = "Error when trying to save image";

        return (new DashboardController)->index($request, $response, ["session" => "new-dish"], [
          "values" => $dataToBeEvaluated,
          "errors" => $errors
        ]);
      }
    } else {
      $errors["image_file"] = "Image sending failed";

      return (new DashboardController)->index($request, $response, ["session" => "new-dish"], [
        "values" => $dataToBeEvaluated,
        "errors" => $errors
      ]);
    }

    $dish = new DishModel;

    $dish->image_name = $imageName;
    $dish->name = $name;
    $dish->description = $description;
    $dish->price = (float) $price;
    $dish->category_id = (int) $category;

    if ($dish->store() !== "0") {
      $response->redirect("/admin/dashboard/dishes");
    } else {
      $errors["store_error"] = "Error when trying to create a new dish";

      return (new DashboardController)->index($request, $response, ["session" => "new-dish"], [
        "values" => $dataToBeEvaluated,
        "errors" => $errors
      ]);
    }
  }
}