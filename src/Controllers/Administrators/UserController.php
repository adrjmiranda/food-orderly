<?php

namespace Src\Controllers\Administrators;

use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;
use Src\Models\UserModel;

class UserController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function remove(Request $request, Response $response, array $params)
  {
    $formData = $request->getQueryParams();

    $id = (int) ($formData["id"] ?? "");

    $userById = (new UserModel)->findOne("id", $id) ?? null;

    if ($userById instanceof UserModel) {
      $userById->delete();
    }

    $response->redirect("/admin/dashboard/users");
  }
}