<?php

namespace Src\Controllers\Users;

use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;
use Src\Models\CategoryModel;

class HomeController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index(Request $request, Response $response, array $params)
  {
    $categories = (new CategoryModel)->all();
    $data['categories'] = $categories;

    $template = view("users/home", $data);

    $response->send($template, 200);
  }

  public function about(Request $request, Response $response, array $params)
  {
    $cacheKey = "Src\\Controllers\\Users\\HomeController@about";
    $cacheData = self::$cached->get($cacheKey);

    if ($cacheData !== false) {
      $template = $cacheData;
    } else {
      $template = view("users/about");
      // TODO: modify cache time
      self::$cached->set($cacheKey, $template, 0);
    }

    $response->send($template, 200);
  }

  public function contact(Request $request, Response $response, array $params)
  {
    $cacheKey = "Src\\Controllers\\Users\\HomeController@contact";
    $cacheData = self::$cached->get($cacheKey);

    if ($cacheData !== false) {
      $template = $cacheData;
    } else {
      $template = view("users/contact");
      // TODO: modify cache time
      self::$cached->set($cacheKey, $template, 0);
    }

    $response->send($template, 200);
  }
}