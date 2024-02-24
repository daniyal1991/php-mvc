<?php

namespace app\core;

class Router
{
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve() {
        $path = $this->request->getPath();
        $method = $this->request->method();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback == false) {
            $this->response->setStatusCode(404);

            return $this->renderView('_404');
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        //Needs this condition bcz call_user_func calls array callback parameter statically
        // e.g. [SiteController::class, 'home'] --> SiteController::home
        if (is_array($callback)) {
            //$callback[0] is controller name e.g. SiteController or it can be $callback[0] = new $callback[0]
            //creating instance of controller class so it can be used in other methods in Router class
            Application::$app->controller = new $callback[0];
            $callback[0] = Application::$app->controller; //converting first index of callback from string to object
        }

        return call_user_func($callback, $this->request);
        //By passing $this->request, we can get 'Request $request' in any controller method
    }

    public function renderView($view, $params=[]) {
        $layout_content = $this->layoutContent();
        $view_content = $this->renderOnlyView($view, $params);

        return str_replace('{{content}}', $view_content, $layout_content);
    }

    protected function layoutContent() {
        $layout = Application::$app->controller->layout;

        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params) {
        //params array passing from controllers to views
        foreach ($params as $key => $param) {
            //declare a variable for each index of $params array to be available in view file
            //e.g. $params = ['name'=>'john doe'], then $name = 'john doe'
            $$key = $param;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }

//    public function renderContent($view_content) {
//        $layout_content = $this->layoutContent();
//
//        return str_replace('{{content}}', $view_content, $layout_content);
//    }
}