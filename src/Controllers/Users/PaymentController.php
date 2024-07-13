<?php

namespace Src\Controllers\Users;

use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;
use Src\Models\UserModel;

class PaymentController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function checkout(Request $request, Response $response, array $params)
  {
    $userId = (int) ($_SESSION["user"]["id"] ?? "");
    $user = (new UserModel)->findOne("id", $userId) ?? null;

    if ($user instanceof UserModel) {
      $data["user"] = $user;
      $template = view("users/payment-area", $data);
      $response->send($template, 200);
    } else {
      $response->redirect("/");
    }
  }

  public function payment(Request $request, Response $response, array $params)
  {
  }
}