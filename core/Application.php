<?php

namespace app\core;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public Controller $controller;

    public function __construct($root_path) {
        self::$ROOT_DIR = $root_path;
        self::$app = $this;
        //full path app\core\Request() not required bcz both Application and Request are in same namespace
        $this->request = new Request();
        $this->response = new Response();

        //passing Request & Response class instances to Router class
        $this->router = new Router($this->request, $this->response);
    }

    public function run() {
        echo $this->router->resolve();
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }
}