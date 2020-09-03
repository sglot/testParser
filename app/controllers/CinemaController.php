<?php

namespace app\controllers;

use app\common\Registry;

class CinemaController extends Controller
{
    private $reg;
    private $ratingManager;
    private $cinemaManager;
    private $cache;

    public function __construct()
    {
        $this->reg = Registry::instance();
        $this->ratingManager = $this->reg->getRatingManager();
        $this->cinemaManager = $this->reg->getCinemaManager();
        $this->cache = $this->reg->getCache();
    }


    /**
     * return detail info for modal window
     */
    public function getDetailJson()
    {
        $origin_id = (int)filter_input(INPUT_GET, 'id');
        if ($origin_id === 0) {
            echo 'error';
            return;
        }

        $name = 'cache_detail_' . $origin_id;
        if (!$cachedData = $this->cache->fetch($name)) {
            $cachedData = $this->cinemaManager->getCinemaByOriginId($origin_id);
            $cachedData = json_encode($cachedData, JSON_UNESCAPED_UNICODE);
            $this->cache->save($name, $cachedData, 24 * 60 * 60);
        }

        echo $cachedData;

    }
}