<?php

namespace Src\Controllers\Administrators;

use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;

class LoginController extends Controller
{
  public function index(Request $request, Response $response, array $params)
  {
    $template = view("administrators/login");
    $response->send($template, 200);
  }
}