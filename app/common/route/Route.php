<?php


namespace app\common\route;


//use app\common\Registry;
//use app\common\request\HttpRequest;
//use app\common\request\Request;
//use app\controllers\ApiController;
//use app\controllers\Controller;

use app\controllers\CinemaController;

class Route
{
    public static function run()
    {

//        /** @var $request Request|HttpRequest*/
//        $request = Registry::instance()->getRequest();
//        $routes = Registry::instance()->getRoutes();
//
//        $method = $request->getMethod();
//        $path = $request->getPath();
//
//        // todo по умолчанию выдаётся ошибка, default не используется
//        $defaultClass = ApiController::class;
//        $defaultAction = 'index';
//        var_dump($request);
//        var_dump($_SERVER);
////        phpinfo();
//
//
//        if (!isset($routes[$method][$path]) && !isset($routes[$method][$path . "/"])) {
//            throw new \Exception("Не существует роут $method $path");
//        }
//
//        if (isset($routes[$method][$path . "/"])) {
//            $path .= "/";
//        }
//
//        $routLine = $routes[$method][$path];
//
//        $controller = explode('@', $routLine);
//        $action = $controller[1];
//        $controller = $controller[0];
//
//        if (!class_exists($controller)) {
//            throw new \Exception("Не существует класс $controller");
//        }
//
//        $reflectionController = new \ReflectionClass($controller);
//        if (!$reflectionController->isSubclassOf(Controller::class)) {
//            throw new \Exception("Класс $controller не относится к контроллерам");
//        }
//
//        if (!$reflectionController->hasMethod($action)) {
//            throw new \Exception("Метод $action не определён в контроллере $controller");
//        }


        $controller = new CinemaController();
        $controller->index();


    }
}