<?php

namespace app\console;

require_once(__DIR__ . '../../../vendor/autoload.php');

use app\controllers\ParserController;
use GuzzleHttp\Exception\GuzzleException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('console');
$logger->setTimezone(new \DateTimeZone('Europe/Moscow'));
$logger->pushHandler(new StreamHandler(__DIR__ . '../../../storage/logs/app.log', Logger::DEBUG));


try {
    $parser = new ParserController($logger);
    $parser->parse();
} catch (\Exception $e) {
    $logger->error($e->getMessage());
    die();
} catch (GuzzleException $e) {
    $logger->error($e->getMessage());
    die();
}

