<?php

namespace Src\Controllers\Users;

use Src\Config\Session\Store;
use Src\Config\Validations\UserRegisterValidate;
use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;
use Src\Models\UserModel;

class RegisterController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index(Request $request, Response $response, array $params, array $data = [])
  {
    $cacheKey = "Src\\Controllers\\Users\\RegisterController@index";
    $cacheData = self::$cached->get($cacheKey);

    if ($cacheData !== false) {
      $template = $cacheData;
    } else {
      $template = view("users/register", $data);
      // TODO: modify cache time
      self::$cached->set($cacheKey, $template, 0);
    }

    $response->send($template, 200);
  }

  public function register(Request $request, Response $response, array $params)
  {
    $formData = $request->getPostVars();

    $firstName = $formData["first_name"] ?? "";
    $lastName = $formData["last_name"] ?? "";
    $email = $formData["email"] ?? "";
    $password = $formData["password"] ?? "";
    $passwordConfirmation = $formData["password_confirmation"] ?? "";

    $dataToBeEvaluated = [
      "first_name" => $firstName,
      "last_name" => $lastName,
      "email" => $email,
      "password" => $password,
      "password_confirmation" => [
        "password" => $password,
        "password_confirmation" => $passwordConfirmation
      ],
    ];

    $errors = (new UserRegisterValidate)->getErrors($dataToBeEvaluated);

    if (!empty($errors)) {
      $data["values"] = [
        "first_name" => $firstName,
        "last_name" => $lastName,
        "email" => $email,
        "password" => $password,
        "password_confirmation" => $passwordConfirmation
      ];
      $data["errors"] = $errors;

      return $this->index($request, $response, $params, $data);
    }

    $user = new UserModel;

    $user->first_name = $firstName;
    $user->last_name = $lastName;
    $user->email = $email;
    $user->password = password_hash($password, PASSWORD_DEFAULT);

    $userId = $user->store();

    if ($userId !== "0") {
      Store::set("user", [
        "id" => $userId,
        "email" => $email,
        "first_name" => $firstName,
        "last_name" => $lastName,
      ]);

      $response->redirect("/");
    }

    return $this->index($request, $response, $params);
  }
}