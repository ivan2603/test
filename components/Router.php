<?php
class Router {

    private $routes;

    public function __construct()
    {
        $routePath = ROOT.'/config/routes.php';
        $this->routes = include($routePath);
    }


    private function getUrl() {

        if (!empty($_SERVER['REQUEST_URI'])) {

            return trim($_SERVER['REQUEST_URI'], '/');

        }
    }

    public function run(){

        //получаем строку запрса
        $url = $this->getUrl();

        //проверка наличия такого запрса в routes.php
        foreach ($this->routes as $urlPattern => $path) {

            //сравниваем $urlPattern и $url
            if (preg_match("~$urlPattern~", $url)) {

                $internalRoute = preg_replace("~$urlPattern~", $path, $url);

                /* определяем какой controller
                and action обрабатывает запрос */
                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action'.ucfirst(array_shift($segments));


                $parameters = $segments;


                //подключаем файл класса-контролера
                $controllerFile = ROOT. '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }
                //создаем обьект, вызываем метод(action)
                $controllerObject = new $controllerName;
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != null) {
                    break;
                }

            }
        }


    }
}