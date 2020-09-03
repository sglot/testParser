<?php

namespace app\controllers;

use app\common\Registry;

class RatingController extends Controller
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
     * return main view
     */
    public function index()
    {
//        $this->cache->flushAll();
        $date = new \DateTime();
        $name = sprintf('cache_rating_%s_%s_%s', $date->format('Y-m-d'), 'pos', 'asc');
        if (!$cachedData = $this->cache->fetch($name)) {
            $categories = [];
            foreach ($this->ratingManager->getRating() as $key => $row) {
                $categories[$row['category']][$key] = $row;
            }
            $cachedData = $categories;
            $this->cache->save($name, $cachedData, 24 * 60 * 60);
        }

        $data['rating'] = $cachedData;
        include_once '../views/index.php';

    }


    /**
     * return filtered list of cinema
     */
    public function getList()
    {
        $res = [];
        $date = null;
        $date = filter_input(INPUT_GET, 'date');
        if ($date && !$this->isDate($date)) {
            return;
        }

        $filter = filter_input(INPUT_GET, 'filter');
        if (!$filter) {
            $filter = 'pos';
        }

        $sort = filter_input(INPUT_GET, 'sort');
        if (!$sort) {
            $sort = 'asc';
        }

        $name = sprintf('cache_rating_%s_%s_%s', $date, $filter, $sort);
        if (!$cachedData = $this->cache->fetch($name)) {
            var_dump('cache no');
            $categories = [];
            foreach ($this->ratingManager->getRating($filter, $sort, $date) as $key => $row) {
                $categories[$row['category']][$key] = $row;
            }

            $cachedData = $categories;
            $this->cache->save($name, $cachedData, 24 * 60 * 60);
        }

        $data['rating'] = $cachedData;
        include_once '../views/content-ajax.php';

    }

    /**
     * @param $str
     * @return bool
     */
    private function isDate($str){
        return is_numeric(strtotime($str));
    }
}