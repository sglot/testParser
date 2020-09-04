<?php

namespace app\controllers;

class CinemaController extends Controller
{
    /**
     * @var \app\services\CinemaService
     */
    private $cinemaService;

    public function __construct()
    {
        parent::__construct();
        $this->cinemaService = $this->reg->getCinemaService();
    }

    /**
     * return detail info for modal window
     */
    public function getDetailJson()
    {
        $cachedData = $this->cinemaService->getDetailJson();
        echo $cachedData;
    }
}