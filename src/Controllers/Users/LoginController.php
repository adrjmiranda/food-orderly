<?php

namespace Src\Controllers\Users;

use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;

class LoginController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index(Request $request, Response $response, array $params)
  {
    $cacheKey = "Src\\Controllers\\Users\\LoginController@index";
    $cacheData = self::$cached->get($cacheKey);

    if ($cacheData !== false) {
      $template = $cacheData;
    } else {
      $template = view("users/login");
      // TODO: modify cache time
      self::$cached->set($cacheKey, $template, 0);
    }

    $response->send($template, 200);
  }
}