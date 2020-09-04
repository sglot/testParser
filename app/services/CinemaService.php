<?php

namespace app\services;


use app\controllers\BaseService;

class CinemaService extends BaseService
{
    /**
     * @var \app\common\DB\CinemaManager
     */
    private $cinemaManager;

    public function __construct()
    {
        parent::__construct();
        $this->cinemaManager = $this->reg->getCinemaManager();
    }


    public function getDetailJson()
    {
        $origin_id = (int)filter_input(INPUT_GET, 'id');
        if ($origin_id === 0) {
            return 'error';
        }

        $name = 'cache_detail_' . $origin_id;
        if (!$cachedData = $this->cache->fetch($name)) {
            $cachedData = $this->cinemaManager->getCinemaByOriginId($origin_id);
            $cachedData = json_encode($cachedData, JSON_UNESCAPED_UNICODE);
            $this->cache->save($name, $cachedData, 24 * 60 * 60);
        }

        return $cachedData;
    }
}