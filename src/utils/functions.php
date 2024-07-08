<?php
use Src\Helpers\Template\View;

function view(string $template, array $data = [])
{
  return (new View)->render($template, $data);
}

