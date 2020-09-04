<?php

namespace app\controllers;

class RatingController extends Controller
{
    /**
     * @var \app\services\RatingService
     */
    private $ratingService;

    public function __construct()
    {
        parent::__construct();
        $this->ratingService = $this->reg->getRatingService();
    }

    /**
     * return main view
     */
    public function index()
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d');
        $cacheName = sprintf('cache_rating_%s_pos_asc', $date);

        $data['rating'] = $this->ratingService->getRating($cacheName, 'pos', 'asc', $date);
        include_once '../views/index.php';
    }


    /**
     * return filtered list of cinema
     */
    public function getList()
    {
        $data['rating'] = $this->ratingService->getList();
        include_once '../views/content-ajax.php';
    }

}