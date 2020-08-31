<?php


namespace app\controllers;


class CinemaController extends Controller
{
    public function index()
    {
        include_once '../views/index.php';

    }

    public function test()
    {

        echo "test";

    }
}