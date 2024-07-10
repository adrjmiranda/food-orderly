<?php

namespace Src\Controllers\Administrators;

use Src\Controllers\Controller;
use Src\Http\Request;
use Src\Http\Response;

class DishController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function store(Request $request, Response $response, array $params)
  {
    $formData = $request->getPostVars();

    $imageFile = $request->getFile("image_file");

    $name = $formData["name"] ?? "";
    $description = $formData["description"] ?? "";
    $price = $formData["price"] ?? "";
    $category = $formData["category"] ?? "";

  }
}