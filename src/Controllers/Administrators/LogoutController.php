<?php

namespace Src\Controllers\Administrators;

use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;
use Src\Models\AdministratorModel;
use Src\Config\Session\Store;

class LogoutController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function logout(Request $request, Response $response, array $params)
  {
    $adminId = $_SESSION["admin"]["id"] ?? "";

    $admin = (new AdministratorModel)->findOne("id", $adminId);

    if ($admin instanceof AdministratorModel) {
      Store::logout("admin");

      $response->redirect("/admin/login");
    }

    $response->redirect("/admin/dashboard/orders");
  }
}