<?php

namespace Src\Controllers\Administrators;

use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;
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

    switch ($session) {
      case "orders":
        $entity = new OrderModel;
        break;

      case "users":
        $entity = new UserModel;
        break;

      case "dishes":
        $entity = new DishModel;
        break;
    }

    $data = $entity->all() ?? [];
    return $data;
  }

  public function index(Request $request, Response $response, array $params)
  {
    $session = $params["session"] ?? "";
    $data["session"] = $session;
    $data["session_title"] = ucwords(str_replace("-", " ", $session));

    $data["items"] = $this->getSessionData($session);

    $template = view("administrators/$session", $data);
    $response->send($template, 200);
  }
}