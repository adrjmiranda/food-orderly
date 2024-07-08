<?php

namespace Src\Config\Logs;

class Logger
{
  const INFO = 'INFO';
  const WARNING = 'WARNING';
  const ERROR = 'ERROR';

  private string $logFile;

  public function __construct(string $logFile)
  {
    $this->logFile = $logFile;
  }

  private function log(string $level, string $message): void
  {
    $date = date("Y-m-d H:i:s");
    $logMessage = "[$date] [$level] $message" . PHP_EOL;
    file_put_contents($this->logFile, $logMessage, FILE_APPEND);
  }

  public function info(string $message): void
  {
    $this->log(self::INFO, $message);
  }

  public function warning(string $message): void
  {
    $this->log(self::WARNING, $message);
  }

  public function error(string $message): void
  {
    $this->log(self::ERROR, $message);
  }
}