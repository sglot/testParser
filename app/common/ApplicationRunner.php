<?php

namespace app\common;

use app\common\Route\Route;

class ApplicationRunner
{
    public static function run()
    {
        $instance = new ApplicationRunner();
        $instance->handleRequest();
    }

    private function handleRequest()
    {
        Route::run();
    }
}