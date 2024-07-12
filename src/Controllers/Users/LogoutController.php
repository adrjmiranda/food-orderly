<?php

namespace Src\Controllers\Users;

use Src\Config\Session\Store;
use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;
use Src\Models\UserModel;

class LogoutController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function logout(Request $request, Response $response, array $params)
  {
    $userId = $_SESSION["user"]["id"] ?? "";

    $user = (new UserModel)->findOne("id", $userId);

    if ($user instanceof UserModel) {
      Store::logout("user");

      $response->redirect("/login");
    }

    $response->redirect("/");
  }
}