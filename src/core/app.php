<?php


namespace core;


class app
{


    private array $routes = [];


    public function __construct()
    {

    }

    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            $route = $this->routes[$requestUri];

            if (isset($route[$requestMethod])) {
                $controllerClassName = $route[$requestMethod]['class'];
                $method = $route[$requestMethod]['method'];


                $class = new $controllerClassName();
                try {
                    return $class->$method();


                }catch (\Throwable $exception){


                    http_response_code(500);
                    require_once "./../View/500.php";
                }
            } else {
                echo "$requestMethod не поддерживается для $requestUri";
            }
        } else {
            http_response_code(404);
            require_once "./../View/404.php";
        }
    }


    public function addPostRoute(string $route, string $class, string $methodName)
    {
        $this->routes[$route]['POST'] = ['class'=> $class, 'method' => $methodName];
    }
    public function addGetRoute(string $route, string $class, string $methodName,string $requestClass = null)
    {
        $this->routes[$route]['GET'] = ['class'=> $class, 'method' => $methodName, 'request' => $requestClass];
    }

}