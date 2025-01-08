<?php

namespace Videoclub\Util;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

class LogFactory{
    public static function getLogger(String $canal = "Videoclub"): LoggerInterface {
        $log = new Logger($canal);
        $log->pushHandler(new StreamHandler(`../logs/${$canal}`, Logger::DEBUG));

        return $log;
    }
}