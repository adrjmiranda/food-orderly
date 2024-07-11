<?php

namespace Src\Controllers\Administrators;

use Src\Config\Session\Store;
use Src\Config\Validations\AdminLoginValidate;
use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;
use Src\Models\AdministratorModel;

class LoginController extends Controller
{
  public function index(Request $request, Response $response, array $params, array $data = [])
  {
    $template = view("administrators/login", $data);
    $response->send($template, 200);
  }

  public function login(Request $request, Response $response, array $params)
  {
    $formData = $request->getPostVars();

    $email = $formData["email"] ?? "";
    $password = $formData["password"] ?? "";

    $dataToBeEvaluated = [
      "email" => $email,
      "password" => [
        "email" => $email,
        "password" => $password
      ]
    ];

    $errors = (new AdminLoginValidate)->getErrors($dataToBeEvaluated);

    if (!empty($errors)) {
      $data["errors"] = $errors;
      $data["values"] = [
        "email" => $email,
        "password" => $password
      ];

      return $this->index($request, $response, $params, $data);
    }

    $admin = (new AdministratorModel)->findOne("email", $email);

    if ($admin instanceof AdministratorModel) {
      Store::set("admin", [
        "id" => $admin->id,
        "first_name" => $admin->first_name,
        "last_name" => $admin->last_name,
        "email" => $admin->email,
      ]);

      $response->redirect("/admin/dashboard/orders");
    }

    return $this->index($request, $response, $params);
  }
}