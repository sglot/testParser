<?php

namespace app\controllers;

require __DIR__ . '\..\..\app\console\phpQuery\phpQuery\phpQuery.php';

use app\common\HttpClient\HttpClient;
use app\common\Registry;
use Monolog\Logger;


/**
 * Class ParserController
 * @package app\controllers
 */
class ParserController extends Controller
{

    const IMG_PATH = __DIR__ . '\..\..\upload\img\\';

    const URLS = [
        'Полный метр' => 'cinema/rating_top.php',
        'Западные сериалы' => 'cinema/rating_tv_top.php?public_list_anchor=1',
        'Японские дорамы' => 'cinema/rating_tv_top.php?public_list_anchor=2',
        'Корейские дорамы' => 'cinema/rating_tv_top.php?public_list_anchor=4',
        'Русские сериалы' => 'cinema/rating_tv_top.php?public_list_anchor=3',

    ];

    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var HttpClient
     */
    private $client;
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var \app\common\DB\CinemaManager
     */
    private $cinemaManager;

    /**
     * ParserController constructor.
     * @param Logger $logger
     * @param HttpClient $client
     */
    public function __construct(Logger $logger, HttpClient $client)
    {
        $this->logger = $logger;
        $this->client = $client;
        $this->registry = Registry::instance();
        $this->cinemaManager = $this->registry->getCinemaManager();

    }

    public function parse()
    {
        $this->logger->info('Старт скрипта');

        foreach (self::URLS as $name => $url) {
            $strOriginalEncoding = $this->client->sendRequest($url);

            $doc = \phpQuery::newDocument($strOriginalEncoding);
            $p = $doc->find('title')->text();
            var_dump($p);
            echo "--------------<br><br><br><br>";

            $p = $doc->find('h3')->parent();
            $p = $p->find('center table ~ table');
            $p = $p->next()->next();
            $p = $p->find('tr');

            $res = [];
            foreach ($p as $trKey => $tr) {
                if ($trKey === 0) {
                    continue;
                }

                $pq = pq($tr);
                $res[$trKey]['position'] = $pq->find('td:eq(0)')->text();
                $res[$trKey]['title'] = $pq->find('td:eq(1)')->text();
                $res[$trKey]['average_score'] = $pq->find('td:eq(2)')->text();
                $res[$trKey]['votes'] = $pq->find('td:eq(3)')->text();
                $res[$trKey]['calculated_score'] = $pq->find('td:eq(4)')->text();

                $res[$trKey]['href'] = 'cinema/' . $pq->find('td:eq(1) > a')->attr('href');
                $res[$trKey]['detail'] = $this->parseCinemaDetail($res[$trKey]['href']);

                $startYearPos = strpos($res[$trKey]['title'], '[');
                $res[$trKey]['year'] = (int)substr($res[$trKey]['title'], $startYearPos + 1, 4);
                $res[$trKey]['title'] = substr($res[$trKey]['title'], 0, $startYearPos - 1);

                if ($trKey > 10) {
                    break;
                }
            }


            echo "<br><br><br><br><br>res===<br><pre>";
            var_dump($res);
            echo "--------------<br>";
            echo mb_detect_encoding($p);
            $this->cinemaManager->addCinemaList($res, $name);
        }

        echo 'script finished';
        $this->logger->info('Скрипт отработал успешно');

    }

    /**
     * @param string $url
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function parseCinemaDetail(string $url): array
    {
        $res = [];
        $strOriginalEncoding = $this->client->sendRequest($url);
        $doc = \phpQuery::newDocument($strOriginalEncoding);
        $p = $doc->find('font:contains(Краткое содержание)')->parent()->parent()->parent()->parent()->next()->text();
        $res['description'] = $p;

        $res['img'] = 'cinema/' . $doc->find('img:eq(1)')->attr('src');
        var_dump($res['img']);
        $res['id'] = mb_substr(stristr($url, 'id='), 3);
        $res['img_path'] = $this->getImage($res['img'], $res['id']);

        return $res;
    }

    /**
     * @param string $url
     * @param string $id
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getImage(string $url, string $id): string
    {
        try {
            $path = self::IMG_PATH . $id . '.jpg';
            $img = $this->client->sendRequest($url);
            $file = fopen($path, 'w');
            fwrite($file, $img);
            fclose($file);

        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            die();
        }

        return $id . '.jpg';
    }


}

