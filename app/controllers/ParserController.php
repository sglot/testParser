<?php
namespace app\controllers;

require 'C:\xampp\htdocs\testParser\app\console\phpQuery\phpQuery\phpQuery.php';

use GuzzleHttp\Client;

class ParserController extends Controller
{
    const URLS = [
        'Полный метр' => 'cinema/rating_top.php'
    ];

    public function parse()
    {
        $client = new Client(['base_uri' => 'http://www.world-art.ru/']);
        $response = $client->request('GET', self::URLS['Полный метр'], [
            'headers' => [
                'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36'
            ]]);

        $strOriginalEncoding = $response->getBody()->getContents();
//$string = mb_convert_encoding($response->getBody()->getContents(), "cp-1251", "UTF-8");
        $string =  iconv('windows-1251', 'UTF-8', $strOriginalEncoding);
//        var_dump($string);

//        $doc = \phpQuery::newDocument($string);
        $doc = \phpQuery::newDocument($strOriginalEncoding);
        $p = $doc->find('title')->text();
        var_dump($p);
        echo  "--------------<br><br><br><br>";

        $p = $doc->find('h3')->parent();
        $p = $p->find('center table ~ table');
        $p = $p->next()->next();
        $p = $p->find('tr');

        $res = [];
        foreach ($p as $trKey => $tr) {
            $pq = pq($tr);
            $row =  $pq->find('td');
//            var_dump($row);die();
            $res[$trKey][0] = $pq->find('td:eq(0)')->text();
            $res[$trKey][1] = $pq->find('td:eq(1)')->text();
            $res[$trKey][2] = $pq->find('td:eq(2)')->text();
            $res[$trKey][3] = $pq->find('td:eq(3)')->text();
            $res[$trKey][4] = $pq->find('td:eq(4)')->text();

        }

        echo "<br><br><br><br><br>res===<br><pre>";
        var_dump($res);

        echo  "--------------<br>";
//$str = mb_convert_encoding($p, "UTF-8");
//        var_dump($p);
        echo mb_detect_encoding($p);

        echo 'script finished';

    }

    public function test()
    {

        echo "test";

    }
}

