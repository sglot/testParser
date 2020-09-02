<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <title>Test parser</title>
    </head>
    <body>

        <div class="container">
            <h1 class="mb-4 mt-4" style="text-align: center">Рейтинг кино и сериалов по версии сайта <a href="http://www.world-art.ru">World Art</a></h1>

            <form>
                <div class="form-group d-flex flex-row justify-content-center">
                    <input type="text" style="width: 30%; text-align: center" class="form-control m-2" id="dateInput" required placeholder="2020-08-31">
                    <button type="button" onclick="filterData()" class="btn btn-primary m-2">Выбрать по дате</button>
                </div>
            </form>
            <pre>
            <?php
            if (isset($data['rating'])):
//                var_dump($data['rating']);
                foreach($data['rating'] as $nameCategory => $category):
            ?>



            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Расчетный балл</th>
                        <th scope="col">Средний балл</th>
                        <th scope="col">Голосов</th>
                        <th scope="col">Год</th>
                    </tr>
                </thead>


                <h2 class="mt-2 mb-2" style="text-align: center"><?=$nameCategory?></h2>
                <tbody>
                    <?php foreach($category as $key => $cinema):?>
                        <tr>
                            <th scope="row"><?=$cinema['pos']?></th>
                            <td style="cursor: pointer" data-toggle="modal" data-target="#exampleModal"><?=$cinema['title']?></td>
                            <td><?=$cinema['average_score']?></td>
                            <td><?=$cinema['calculated_score']?></td>
                            <td><?=$cinema['votes']?></td>
                            <td><?=$cinema['year']?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>


            <?php
                endforeach;
            endif;

            ?>


        </div>


        <!-- Button trigger modal -->
<!--        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">-->
<!--            Запустить модальное окно-->
<!--        </button>-->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<!--                        <button type="button" class="btn btn-primary">Save changes</button>-->
                    </div>
                </div>
            </div>
        </div>

<?php

//require 'C:\xampp\htdocs\testParser\app\console\script.php';



?>


        <footer>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script src="js/main.js"></script>
        </footer>
    </body>
</html>