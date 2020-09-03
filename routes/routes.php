<?php

return [
    'GET' =>
        [
            '/' => 'app\controllers\RatingController@index',
            '/detail-json' => 'app\controllers\CinemaController@getDetailJson',
            '/rating/list' => 'app\controllers\RatingController@getList'
        ]
];