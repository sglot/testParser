<?php

namespace app\controllers;

require 'C:\xampp\htdocs\testParser\app\console\phpQuery\phpQuery\phpQuery.php';


use app\common\HttpClient\HttpClient;
use Monolog\Logger;
use PDO;
use PDOException;


class ParserController extends Controller
{
    const URLS = [
        'Полный метр' => 'cinema/rating_top.php',
        'Западные сериалы' => 'cinema/rating_tv_top.php?public_list_anchor=1',
    ];

    const IMG_PATH = __DIR__ . '\..\..\upload\img\\';

    private $logger;
    private $client;

    public function __construct(Logger $logger, HttpClient $client)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    public function parse()
    {
        $this->logger->info('Старт скрипта');

        foreach (self::URLS as $name => $url) {
            $strOriginalEncoding = $this->client->sendRequest($url);

//            $strOriginalEncoding = mb_convert_encoding($strOriginalEncoding, "cp-1251", "UTF-8");
//            $strOriginalEncoding = iconv('windows-1251', 'UTF-8', $strOriginalEncoding);
//        var_dump($string);
//        $doc = \phpQuery::newDocument($string);
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
                $res[$trKey]['number'] = $pq->find('td:eq(0)')->text();
                $res[$trKey]['title'] = $pq->find('td:eq(1)')->text();
                $res[$trKey]['average_score'] = $pq->find('td:eq(2)')->text();
                $res[$trKey]['votes'] = $pq->find('td:eq(3)')->text();
                $res[$trKey]['calculated_score'] = $pq->find('td:eq(4)')->text();

                $res[$trKey]['href'] = 'cinema/' . $pq->find('td:eq(1) > a')->attr('href');
                $res[$trKey]['detail'] = $this->parseCinemaDetail($res[$trKey]['href']);

                if ($trKey > 5) {
                    break;
                }
            }


            echo "<br><br><br><br><br>res===<br><pre>";
            var_dump($res);
            echo "--------------<br>";
            echo mb_detect_encoding($p);
            $this->db($res, $name);
        }

        echo 'script finished';
        $this->logger->info('Скрипт отработал успешно');

    }

    private function parseCinemaDetail(string $url): array
    {
        $res = [];
        $strOriginalEncoding = $this->client->sendRequest($url);
        $doc = \phpQuery::newDocument($strOriginalEncoding);
        $p = $doc->find('font:contains(Краткое содержание)')->parent()->parent()->parent()->parent()->next()->text();
        $res['description'] = $p;

        $img = 'cinema/' . $doc->find('img:eq(1)')->attr('src');
        var_dump($img);
        $res['img'] = $img;

        $res['id'] = mb_substr(stristr($url, 'id='), 3);
        $res['img_path'] = $this->getImage($res['img'], $res['id']);


        return $res;
    }

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

    private function db($data, $category)
    {
        echo "=================================== PХАПРОС В БД";
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=test_parser;charset=utf8', 'root', '');

            foreach ($data as $cinema) {
                $sql = sprintf("INSERT INTO cinema (origin_id, title, category, image, description)
VALUES (%d, '%s', '%s', '%s', '%s')",
                    $cinema['detail']['id'],
                    $cinema['title'],
                    $category,
                    $cinema['detail']['img_path'],
                    $cinema['detail']['description']
                );

                $dbh->query($sql);
            }


            $dbh = null;
        } catch (PDOException $e) {
            $this->logger->error($e->getMessage());
            die();
        }
    }
    public function test()
    {

        echo "test";

    }
}

