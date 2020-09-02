<?php

namespace app\console;

use app\controllers\ParserController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use app\common\HttpClient\HttpClient;

$logger = new Logger('console');
$logger->pushHandler(new StreamHandler(__DIR__ . '..\..\..\logs\app.log', Logger::DEBUG));


try {
    $parser = new ParserController($logger, new HttpClient());
    $parser->parse();
} catch (\Exception $e) {
    $logger->error($e->getMessage());
    die();
}

