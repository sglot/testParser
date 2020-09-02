<?php

return [
    'GET' =>
        [
            '/' => 'app\controllers\CinemaController@index',
            '/detail-json' => 'app\controllers\CinemaController@getDetailJson'
        ]
];