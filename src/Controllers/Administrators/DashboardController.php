<?php

namespace Src\Controllers\Administrators;

use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;

class DashboardController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index(Request $request, Response $response, array $params)
  {
    $cacheKey = "Src\\Controllers\\Users\\HomeController@index";
    $cacheData = self::$cached->get($cacheKey);

    if ($cacheData !== false) {
      $template = $cacheData;
    } else {
      $template = view("administrators/dashboard");
      // TODO: modify cache time
      self::$cached->set($cacheKey, $template, 0);
    }

    $response->send($template, 200);
  }
}