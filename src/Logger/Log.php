<?php
declare(strict_types=1);

namespace Pulle\Crusader\Logger;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use \Monolog\Handler\FirePHPHandler;
use Monolog\Level;


class Log
{

    public function databaseLog()
    {
        $logger = new Logger('Database');
        $logger->pushHandler(new StreamHandler(__DIR__.'/logs/SchoolExchangeMain.log', Level::Debug));
        $logger->pushHandler(new FirePHPHandler());
        return $logger;
    }

    public function uiLog()
    {
        $logger = new Logger('ui');
        $logger->pushHandler(new StreamHandler(__DIR__.'/logs/ui.log', Level::Debug));
        $logger->pushHandler(new FirePHPHandler());
        return $logger;
    }

    public function processLog()
    {
        $logger = new Logger('process');
        $logger->pushHandler(new StreamHandler(__DIR__.'/logs/auth.log', Level::Debug));
        $logger->pushHandler(new FirePHPHandler());
        return $logger;
    }
}