<?php
use Src\Config\Logs\Logger;
use Src\Helpers\Template\View;

function view(string $template, array $data = [])
{
  return (new View(new Logger))->render($template, $data);
}

