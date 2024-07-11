<?php

namespace Src\Controllers\Administrators;

use Src\Config\Validations\DishValidate;
use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;
use Src\Models\CategoryModel;
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

  public function edit(Request $request, Response $response, array $params, array $data = [])
  {
    $formData = $request->getQueryParams();

    $id = (int) ($formData["id"] ?? "");

    if (isset($data["editable_dish"])) {
      $id = $data["editable_dish"]->id;
    }

    $dishById = (new DishModel)->findOne("id", $id);

    if ($dishById instanceof DishModel) {
      if (isset($data["editable_dish"])) {
        $data["dish"] = $data["editable_dish"];
      } else {
        $data["dish"] = $dishById;
      }

      $categories = (new CategoryModel)->all() ?? [];
      $data["categories"] = $categories;

      $data["session_title"] = "Edit Dish";

      $template = view("administrators/edit-dish", $data);
      $response->send($template, 200);
    } else {
      return (new DashboardController)->index($request, $response, ["session" => "dishes"]);
    }
  }

  public function update(Request $request, Response $response, array $params)
  {
    $formData = $request->getPostVars();

    $id = (int) ($formData["id"] ?? "");

    $dishById = (new DishModel)->findOne("id", $id);

    if (!($dishById instanceof DishModel)) {
      $response->redirect("/admin/dashboard/dishes");
    }

    $imageFile = $request->getFile("image_file");

    $dishById->name = $formData["name"] ?? "";
    $dishById->description = $formData["description"] ?? "";
    $dishById->price = (float) ($formData["price"] ?? "");
    $dishById->category_id = (int) ($formData["category"] ?? "");

    $dataToBeEvaluated = [
      "name" => $dishById->name,
      "description" => $dishById->description,
      "price" => $dishById->price,
      "category" => $dishById->category_id
    ];

    if ($imageFile["size"] !== 0) {
      $dataToBeEvaluated["image_file"] = [
        "extension" => $imageFile["type"],
        "size" => $imageFile["size"]
      ];
    }

    $errors = (new DishValidate)->getErrors($dataToBeEvaluated);

    if (!empty($errors)) {
      $data["editable_dish"] = $dishById;
      $data["errors"] = $errors;

      return $this->edit($request, $response, $params, $data);
    }

    $dish = new DishModel;

    if ($imageFile["size"] !== 0) {
      if ($imageFile["error"] === UPLOAD_ERR_OK) {
        $imageDir = __DIR__ . "/../../../assets/img/dishes/";

        if (!is_dir($imageDir)) {
          mkdir($imageDir, 0755, true);
        }

        $imageName = bin2hex(random_bytes(48)) . ".jpg";

        $imageFilePath = $imageDir . $imageName;

        if (unlink($imageDir . $dishById->image_name)) {
          if (!move_uploaded_file($imageFile["tmp_name"], $imageFilePath)) {
            $errors["image_file"] = "Error when trying to save image";
            $data["editable_dish"] = $dishById;
            $data["errors"] = $errors;

            return $this->edit($request, $response, $params, $data);
          }

          $dish->image_name = $imageName;
        } else {
          $errors["image_file"] = "Error when trying to save image";
          $data["editable_dish"] = $dishById;
          $data["errors"] = $errors;

          return $this->edit($request, $response, $params, $data);
        }
      } else {
        $errors["image_file"] = "Image sending failed";
        $data["editable_dish"] = $dishById;
        $data["errors"] = $errors;

        return $this->edit($request, $response, $params, $data);
      }
    }

    $dish->id = $dishById->id;
    $dish->name = $dishById->name;
    $dish->description = $dishById->description;
    $dish->price = $dishById->price;
    $dish->category_id = $dishById->category_id;

    if ($dish->update()) {
      $response->redirect("/admin/dashboard/dishes");
    } else {
      $errors["update_error"] = "Error when trying to create a new dish";
      $data["editable_dish"] = $dishById;
      $data["errors"] = $errors;

      return $this->edit($request, $response, $params, $data);
    }
  }

  public function delete(Request $request, Response $response, array $params)
  {
  }
}