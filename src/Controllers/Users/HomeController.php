<?php

namespace Src\Controllers\Users;

use Src\Http\Request;
use Src\Http\Response;

class HomeController
{
  public function index(Request $request, Response $response, array $params)
  {
    $template = view('users/home');
    $response->send($template, 200);
  }
}