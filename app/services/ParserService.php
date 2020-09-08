<?php

namespace app\services;


use app\common\HttpClient\HttpClient;
use Monolog\Logger;

class ParserService extends BaseService
{
    const IMG_PATH = __DIR__ . '/../../web/upload/img/';

    const URLS = [
        'Полный метр' => 'cinema/rating_top.php',
        'Западные сериалы' => 'cinema/rating_tv_top.php?public_list_anchor=1',
        'Японские дорамы' => 'cinema/rating_tv_top.php?public_list_anchor=2',
        'Корейские дорамы' => 'cinema/rating_tv_top.php?public_list_anchor=4',
        'Русские сериалы' => 'cinema/rating_tv_top.php?public_list_anchor=3',

    ];

    /**
     * @var \app\common\DB\RatingManager
     */
    private $cinemaManager;
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var HttpClient
     */
    private $client;

    /**
     * ParserController constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        parent::__construct();
        $this->logger = $logger;
        $this->client = $this->reg->getClient();
        $this->cinemaManager = $this->reg->getCinemaManager();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function parse()
    {
        foreach (self::URLS as $name => $url) {
            $strOriginalEncoding = $this->client->sendRequest($url);
            $doc = \phpQuery::newDocument($strOriginalEncoding);

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
                $res[$trKey]['calculated_score'] = $pq->find('td:eq(2)')->text();
                $res[$trKey]['votes'] = $pq->find('td:eq(3)')->text();
                $res[$trKey]['average_score'] = $pq->find('td:eq(4)')->text();

                $res[$trKey]['href'] = 'cinema/' . $pq->find('td:eq(1) > a')->attr('href');
                $res[$trKey]['detail'] = $this->parseCinemaDetail($res[$trKey]['href']);

                $res[$trKey]['title'] = str_replace( '[ТВ]', '', $res[$trKey]['title']);
                $startYearPos = strpos($res[$trKey]['title'], '[');
                $res[$trKey]['year'] = (int)substr($res[$trKey]['title'], $startYearPos + 1, 4);
                $res[$trKey]['title'] = substr($res[$trKey]['title'], 0, $startYearPos - 1);

                if ($trKey > 15) {
                    break;
                }
            }

            echo $name . ' ok' . PHP_EOL;

            $this->cinemaManager->addCinemaList($res, $name);
        }
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

        return 'upload/img/' . $id . '.jpg';
    }

}