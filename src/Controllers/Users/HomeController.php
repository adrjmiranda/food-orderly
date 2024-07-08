<?php

namespace Src\Controllers\Users;

use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;

class HomeController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index(Request $request, Response $response, array $params)
  {
    $cacheKey = "home";
    $cacheData = $this->cached->get($cacheKey);

    if ($cacheData !== false) {
      $template = $cacheData;
    } else {
      $template = view("users/home");
      $this->cached->set($cacheKey, $template, 10);
    }

    $response->send($template, 200);
  }
}