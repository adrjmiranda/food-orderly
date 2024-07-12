<?php

namespace Src\Controllers\Users;

use Src\Config\Session\Store;
use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;
use Src\Config\Validations\UserLoginValidate;
use Src\Models\UserModel;

class LoginController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index(Request $request, Response $response, array $params, array $data = [])
  {
    $cacheKey = "Src\\Controllers\\Users\\LoginController@index";
    $cacheData = self::$cached->get($cacheKey);

    if ($cacheData !== false) {
      $template = $cacheData;
    } else {
      $template = view("users/login", $data);
      // TODO: modify cache time
      self::$cached->set($cacheKey, $template, 0);
    }

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

    $errors = (new UserLoginValidate)->getErrors($dataToBeEvaluated);

    if (!empty($errors)) {
      $data["errors"] = $errors;
      $data["values"] = [
        "email" => $email,
        "password" => $password
      ];

      return $this->index($request, $response, $params, $data);
    }

    $user = (new UserModel)->findOne("email", $email);

    if ($user instanceof UserModel) {
      Store::set("user", [
        "id" => $user->id,
        "first_name" => $user->first_name,
        "last_name" => $user->last_name,
        "email" => $user->email,
      ]);

      $response->redirect("/");
    }

    return $this->index($request, $response, $params);
  }
}