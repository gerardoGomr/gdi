<?php
namespace GDI\Aplicacion;

use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

/**
 * Class Logger
 * @package GDI\Aplicacion
 * @author  Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Logger
{
    private $logger;
    private $handler;

    public function __construct(MonologLogger $logger, StreamHandler $handler)
    {
        $this->logger  = $logger;
        $this->handler = $handler;
    }

    public function log(\Exception $e)
    {
        $this->logger->pushHandler($this->handler);
        $this->logger->addError($e->getMessage());
    }
}