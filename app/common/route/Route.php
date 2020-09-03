<?php


namespace app\common\route;

use app\controllers\Controller;
use app\controllers\RatingController;

class Route
{
    public static function run()
    {
        $defaultClass = RatingController::class;
        $defaultAction = 'index';

        try {
            $path = str_replace('/testParser', '', $_SERVER['PATH_INFO']);
            $method = $_SERVER['REQUEST_METHOD'];

            $routes = require_once __DIR__ . '/../../../routes/routes.php';

            if (!isset($routes[$method][$path]) && !isset($routes[$method][$path . "/"])) {
                throw new \Exception("Не существует роут $method $path");
            }

            if (isset($routes[$method][$path . "/"])) {
                $path .= "/";
            }

            $routLine = $routes[$method][$path];

            $controller = explode('@', $routLine);
            $action = $controller[1];
            $controller = $controller[0];

            if (!class_exists($controller)) {
                throw new \Exception("Не существует класс $controller");
            }

            $reflectionController = new \ReflectionClass($controller);
            if (!$reflectionController->isSubclassOf(Controller::class)) {
                throw new \Exception("Класс $controller не относится к контроллерам");
            }

            if (!$reflectionController->hasMethod($action)) {
                throw new \Exception("Метод $action не определён в контроллере $controller");
            }

            $controller = new $controller;
            $controller->$action();

        } catch (\Exception $exception) {
            $controller = new $defaultClass;
            $controller->$defaultAction();
        }
    }
}