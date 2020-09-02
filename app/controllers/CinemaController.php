<?php


namespace app\controllers;


use app\common\Registry;

class CinemaController extends Controller
{
    private $reg;
    private $ratingManager;

    public function __construct()
    {
        $this->reg = Registry::instance();
        $this->ratingManager = $this->reg->getRatingManager();
    }
    public function index()
    {
        $categories = [];
        foreach ($this->ratingManager->getRating() as $key => $row) {
            $categories[$row['category']][$key] = $row;
        }


        $data['rating'] = $categories;
        include_once '../views/index.php';

    }

    public function test()
    {

        echo "test";

    }
}