<?php

namespace Src\Config\Logs;

class Logger
{
  const INFO = 'INFO';
  const WARNING = 'WARNING';
  const ERROR = 'ERROR';

  private function log(string $level, string $message): void
  {
    $date = date("Y-m-d H:i:s");
    $logMessage = "[$date] [$level] $message" . PHP_EOL;

    $logFile = '';

    switch ($level) {
      case self::INFO:
        $logFile = __DIR__ . '/../../resources/logs/info.log';
        break;

      case self::WARNING:
        $logFile = __DIR__ . '/../../resources/logs/warning.log';
        break;

      case self::ERROR:
        $logFile = __DIR__ . '/../../resources/logs/error.log';
        break;
    }

    file_put_contents($logFile, $logMessage, FILE_APPEND);
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