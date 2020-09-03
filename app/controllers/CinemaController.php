<?php

namespace app\controllers;

use app\common\Registry;

class CinemaController extends Controller
{
    private $reg;
    private $ratingManager;
    private $cinemaManager;

    public function __construct()
    {
        $this->reg = Registry::instance();
        $this->ratingManager = $this->reg->getRatingManager();
        $this->cinemaManager = $this->reg->getCinemaManager();
    }


    /**
     * return detail info for modal window
     */
    public function getDetailJson()
    {
        $res = [];
        $origin_id = (int)filter_input(INPUT_GET, 'id');
        if ($origin_id !== 0) {
            $res = $this->cinemaManager->getCinemaByOriginId($origin_id);
        }

        $res = json_encode($res, JSON_UNESCAPED_UNICODE);
        echo $res;

    }
}