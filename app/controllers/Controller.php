<?php


namespace app\controllers;
use app\common\Registry\Registry;

class Controller
{
    protected $reg;
    protected $ratingManager;
    protected $cinemaManager;
    protected $cache;

    public function __construct()
    {
        $this->reg = Registry::instance();
        $this->ratingManager = $this->reg->getRatingManager();
        $this->cinemaManager = $this->reg->getCinemaManager();
        $this->cache = $this->reg->getCache();
    }
}