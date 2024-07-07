<?php

require_once __DIR__ . '/bootstrap.php';

use Src\Controllers\Users\HomeController;

(new HomeController)->index();