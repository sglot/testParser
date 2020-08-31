<?php

namespace app\common;

use app\common\route\Route;

class ApplicationRunner
{
//    private $registry;
//
//    private function __construct()
//    {
//        $this->registry = Registry::instance();
//    }

    public static function run()
    {
        $instance = new ApplicationRunner();
//        $instance->init();
        $instance->handleRequest();

    }

//    private function init()
//    {
//        $this->registry->getApplicationHelper()->init();
//    }

    private function handleRequest()
    {
        Route::run();
    }
}