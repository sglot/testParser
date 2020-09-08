<?php

namespace app\controllers;

//require __DIR__ . '/../../app/console/phpQuery/phpQuery/phpQuery.php';

use Monolog\Logger;


/**
 * Class ParserController
 * @package app\controllers
 */
class ParserController extends Controller
{
    /**
     * @var \app\services\ParserService
     */
    private $parseService;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * ParserController constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        parent::__construct();
        $this->parseService = $this->reg->getParserService($this->logger);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function parse()
    {
        $this->logger->info('Старт скрипта');
        $this->parseService->parse();
        $this->cache->flushAll();
        echo 'script finished';
        $this->logger->info('Скрипт отработал успешно');
    }
}

