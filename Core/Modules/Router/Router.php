<?php

namespace Core\Modules\Router;

use Core\App;
use Core\Views\HtmlView;

class Router
{
    private $route_params = [];

    public function __construct()
    {
        $route = $this->getClearRoute($_SERVER['REQUEST_URI']);

        if (!$params = $this->getInfoByCurrentRoute($route)) {
            $this->return404();
        } else {
            $this->generateAction($params);
        }
    }

    /**
     * Prepare route for search in routes
     * @param string
     * @return string
     */
    private function getClearRoute($route)
    {
        // if not set route than generate main page
        $route = $route ?? '/';

        // if last symbol is '/' than delete him
        if (strlen($route) > 1 && substr($route, -1, 1) === '/') {
            $route = substr($route, 0, -1);
        }

        return $route;
    }

    /**
     * Get match route and routes and return info by route
     * @param $route
     * @return array
     */
    private function getInfoByCurrentRoute($route)
    {
        $params = [];

        foreach (App::$config['routes'] as $config_route => $config_params) {
            // simple route
            if ($route === $config_route) {
                return $config_params;
            }

            // difficult route
            if (strpos($route, $config_route) === 0) {
                $end_route = substr($route, strlen($config_route));

                $params_get_route = explode('/', $this->getClearRoute($end_route));
                $count_variables = count($params_get_route);

                if (isset($config_params['params']) && $count_variables == count($config_params['params'])) {
                    $count_complete_variables = 0;

                    foreach ($config_params['params'] as $var_name) {
                        $this->route_params[$var_name] = $params_get_route[$count_complete_variables++];
                    }

                    return $config_params;
                }
            }
        }

        return [];
    }

    /**
     * @param array $params
     * @return bool
     */
    private function generateAction(array $params)
    {
        // complete name to fullname
        $controller_name = 'App\\Controllers\\' . $params['controller'];
        $method = $params['action'];

        if ($controller_name && $method) {
            // create new class with needed method
            $controller = new $controller_name(new HtmlView());

            if (empty($this->route_params)) {
                $controller->$method();
            } else {
                $controller->$method($this->route_params);
            }

            return true;
        }

        $this->return404();
        return false;
    }

    /**
     * return 404
     */
    private function return404()
    {
        // TODO: create controller and view
        header('HTTP/1.0 404 Not Found', true, 404);
    }
}
