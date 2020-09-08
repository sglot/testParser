<?php

namespace app\services;


class RatingService extends BaseService
{
    /**
     * @var \app\common\DB\RatingManager
     */
    private $ratingManager;

    public function __construct()
    {
        parent::__construct();
        $this->ratingManager = $this->reg->getRatingManager();
    }

    public function getList()
    {
        $date = null;
        $date = filter_input(INPUT_GET, 'date');
        if ($date && !$this->isDate($date)) {
            return [];
        }

        $filter = filter_input(INPUT_GET, 'filter');
        if (!$filter) {
            $filter = 'pos';
        }

        $sort = filter_input(INPUT_GET, 'sort');
        if (!$sort) {
            $sort = 'asc';
        }

        $cacheName = sprintf('cache_rating_%s_%s_%s', $date, $filter, $sort);

        return $this->getRating($cacheName, $filter, $sort, $date);
    }

    /**
     * @param $str
     * @return bool
     */
    private function isDate($str){
        return is_numeric(strtotime($str));
    }

    /**
     * @param $name
     * @param $filter
     * @param $sort
     * @param $date
     * @return array|false|mixed
     */
    public function getRating($name, $filter, $sort, $date)
    {
        if (!$cachedData = $this->cache->fetch($name)) {
            $categories = [];
            foreach ($this->ratingManager->getRating($filter, $sort, $date) as $key => $row) {
                $categories[$row['category']][$key] = $row;
            }

            $cachedData = $categories;
            $this->cache->save($name, $cachedData, 24 * 60 * 60);
        }
        return $cachedData;
    }
}