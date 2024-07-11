<?php

namespace Src\Controllers\Administrators;

use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;
use Src\Models\CategoryModel;
use Src\Models\DishModel;
use Src\Models\OrderModel;
use Src\Models\UserModel;

class DashboardController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  private function getSessionData(string $session)
  {
    $entity = null;
    $fields = [];

    switch ($session) {
      case "orders":
        $entity = new OrderModel;
        $fields = ["id", "amount", "status", "customers_first_name", "customers_last_name", "created_at"];
        break;

      case "users":
        $entity = new UserModel;
        $fields = ["id", "first_name", "last_name", "email", "created_at"];
        break;

      case "dishes":
        $entity = new DishModel;
        $fields = ["id", "name", "price", "category_id", "updated_at"];
        break;

      default:
        return [];
    }

    $items = $entity->findSpecificFields($fields) ?? [];
    return $items;
  }

  public function index(Request $request, Response $response, array $params, array $data = [])
  {
    $session = $params["session"] ?? "";
    $data["session"] = $session;
    $data["session_title"] = ucwords(str_replace("-", " ", $session));

    $categories = (new CategoryModel)->all();

    $data["items"] = $this->getSessionData($session);
    $data["categories"] = $categories;

    $template = view("administrators/$session", $data);
    $response->send($template, 200);
  }

  public function getDishesByName(Request $request, Response $response, array $params)
  {
    $formData = $request->getQueryParams();

    $search = $formData["search"] ?? "";

    $dishes = (new DishModel)->findByText(["id", "name", "price", "category_id", "updated_at"], "name", $search);

    $data["items"] = $dishes;

    $template = view("administrators/dishes", $data);
    $response->send($template, 200);
  }
}