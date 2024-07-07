<?php

namespace Src\Controllers\Users;

use Src\Helpers\Template\View;

class HomeController
{
  public function index()
  {
    echo (new View)->render('users/home');
  }
}