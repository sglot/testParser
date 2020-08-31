<!DOCTYPE html>
<html lang="ru">
    <header>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <title>Test parser</title>
    </header>
    <body>

        <div class="container">
            <h1 class="mb-4 mt-4" style="text-align: center">Рейтинг кино и сериалов по версии сайта <a href="http://www.world-art.ru">World Art</a></h1>

            <form>
                <div class="form-group">
                    <label for="dateInput">Введите дату для выборки</label>
                    <input type="text" class="form-control w-50" id="dateInput" required placeholder="2020-08-31">
                </div>
            </form>

            <h2 class="mt-2 mb-2" style="text-align: center">Категория</h2>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                    <th scope="col">Расчетный балл</th>
                    <th scope="col">Голосов</th>
                    <th scope="col">Средний балл</th>
                    <th scope="col">Год</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>

        </div>

        <footer>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        </footer>
    </body>
</html>

<?php
require 'D:\work\htdocs\testParser\app\console\phpQuery\phpQuery\phpQuery.php';

$hbr =
    file_get_contents('http://www.world-art.ru/cinema/rating_tv_top.php?limit_1=50&public_list_anchor=1');

$document = phpQuery::newDocument($hbr);

$hentry = $document->find('center');
$hentry = $hentry->nextAll();
echo '<pre>';
var_dump($hentry);die();
foreach ($hentry as $el) {
    $pq = pq($el); // Это аналог $ в jQuery
    // меняем атрибуты найденого элемента
    $pq->find('h2.entry-title > a.blog')->attr('href',
        'http://%username%.habrahabr.ru/blog/')->html('%username%');
    $pq->find('div.entry-info')->remove();//удаляем ненужный эл-нт
    $tags = $pq->find('ul.tags > li > a');
    $tags->append(': ')->prepend(' :'); // добавляем : по бокам
    // добавляем контент в начало найденого элемента
    $pq->find('div.content')->prepend('<br />')->prepend($tags);
}

echo $hentry;
?>