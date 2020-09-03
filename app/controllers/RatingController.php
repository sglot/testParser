<?php

namespace app\controllers;

use app\common\Registry;

class RatingController extends Controller
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
     * return main view
     */
    public function index()
    {
        $categories = [];
        foreach ($this->ratingManager->getRating() as $key => $row) {
            $categories[$row['category']][$key] = $row;
        }


        $data['rating'] = $categories;
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

        $categories = [];
        foreach ($this->ratingManager->getRating($filter, $sort, $date) as $key => $row) {
            $categories[$row['category']][$key] = $row;
        }

        $data['rating'] = $categories;
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