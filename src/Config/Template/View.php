<?php

namespace Src\Config\Template;

use Exception;
use Src\Config\Logs\Logger;

class View
{
  private mixed $masterContent;
  private string $masterTemplate;
  private array $masterData;
  private Logger $logger;

  public function __construct(Logger $logger)
  {
    $this->logger = $logger;
  }

  private function getTemplateFilePath(string $template): ?string
  {
    [$folder, $page] = explode('/', $template);

    $validPattern = "/^[a-z-]+$/";
    if (!preg_match($validPattern, $folder) || !preg_match($validPattern, $page)) {
      $this->logger->error("Incorrect Template Name");
      throw new Exception("Server Error", 500);
    }

    $filePath = __DIR__ . '/../../views/pages/' . $folder . '/' . $page . '.php';
    if (file_exists($filePath)) {
      return $filePath;
    } else {
      $this->logger->error("Page $page.php Does Not Exist");
      throw new Exception("Server Error", 500);
    }
  }

  public function render(string $template, array $data = [])
  {
    $templateFile = $this->getTemplateFilePath($template);

    ob_start();

    extract($data);

    require_once $templateFile;

    $content = ob_get_contents();

    ob_end_clean();

    if (!empty($this->masterTemplate)) {
      $allData = array_merge($data, $this->masterData);
      $layout = $this->masterTemplate;

      $this->masterContent = $content;
      $this->masterTemplate = '';

      return $this->render($layout, $allData);
    }

    return $content;
  }

  private function extend(string $masterTemplate, array $masterData = []): void
  {
    $this->masterTemplate = $masterTemplate;
    $this->masterData = $masterData;
  }

  private function load(): void
  {
    echo $this->masterContent;
  }
}