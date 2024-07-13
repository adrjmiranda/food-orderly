<?php

namespace Src\API\V1\Controllers;

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

  public function getAllDishes(Request $request, Response $response, array $params)
  {
    $limit = (int) ($params["limit"] ?? "");

    $data = (new DishModel)->all("DESC", $limit);
    $content = [
      "data" => $data,
      "error" => ""
    ];
    $response->send($content, 200, "application/json");
  }

  public function getDishesByCategory(Request $request, Response $response, array $params)
  {
    $categoryId = (int) ($params["category_id"] ?? "");

    if ($categoryId === 0) {
      $params["limit"] = "0";
      return $this->getAllDishes($request, $response, $params);
    }

    $data = (new DishModel)->findSpecificFieldsAndCondition(["id", "name", "image_name", "description", "price", "category_id"], "category_id", "=", $categoryId);
    $content = [
      "data" => $data,
      "error" => ""
    ];
    $response->send($content, 200, "application/json");
  }
}