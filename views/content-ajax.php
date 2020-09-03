<?php

if (!isset($data['rating']) || empty($data['rating'])):
    echo 'Нет данных';
else:
//                var_dump($data['rating']);
    foreach ($data['rating'] as $nameCategory => $category):
        ?>


        <table class="table m-4">
            <thead>
            <tr>
                <th onclick="fieldFilter('pos')" scope="col" style="cursor: pointer">#</th>
                <th onclick="fieldFilter('title')" scope="col" style="cursor: pointer">Название</th>
                <th onclick="fieldFilter('calculated_score')" scope="col" style="cursor: pointer">Расчетный балл</th>
                <th onclick="fieldFilter('votes')" scope="col" style="cursor: pointer">Голосов</th>
                <th onclick="fieldFilter('average_score')" scope="col" style="cursor: pointer">Средний балл</th>
                <th onclick="fieldFilter('year')" scope="col" style="cursor: pointer">Год</th>
            </tr>
            </thead>


            <h2 class="mt-4 mb-4" style="text-align: center"><?= $nameCategory ?></h2>
            <tbody>
            <?php foreach ($category as $key => $cinema): ?>
                <tr>
                    <th scope="row"><?= $cinema['pos'] ?>(<?= $cinema['date_created'] ?>)</th>
                    <td style="cursor: pointer"
                        onclick="getDetail(<?= $cinema['origin_id'] ?>)"
                        data-toggle="modal"
                        data-target="#exampleModal"
                    >
                        <img src="upload/img/<?= $cinema['image'] ?>"
                             style="height: 100px;"
                             title="<?= $cinema['title'] ?>">
                    </td>
                    <td><?= $cinema['calculated_score'] ?></td>
                    <td><?= $cinema['votes'] ?></td>
                    <td><?= $cinema['average_score'] ?></td>
                    <td><?= $cinema['year'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>


    <?php
    endforeach;
endif;

?>