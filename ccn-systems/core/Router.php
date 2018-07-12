<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 25.08.16
 * Time: 14:29
 */

namespace Core;

use Controllers\MainController;
use Controllers\HubController;
use Controllers\UserController;


class Router {

    public $routes = array();
    private $parameters = array();
    public $url = '';

    public function addRoute($route, $path=null) {
        if ($path != null && !is_array($route)) {
            $route = array($route => $path);
        }
        $this->routes = array_merge($this->routes, $route);
    }

    public function assemble($url) {
        return preg_split('/\//', $url, -1, PREG_SPLIT_NO_EMPTY);
    }

    public function getUrl() {
        return ($this->url?:'/');
    }

    public function dispatch($url = null) {

        if ($url === null) {
//            $uri = explode('?', $_SERVER["REQUEST_URI"]);
            $url = rtrim($_SERVER["REQUEST_URI"]);
        }
        $this->$url = $url;

        if (isset($this->routes[$url])) {
            $this->parameters = $this->assemble($this->routes[$url]);
            return $this->executeAction();
        }

        foreach ($this->routes as $route => $uri) {
            if (strpos($route, ':') !== false) {
                $route = str_replace(':any', '(.+)', str_replace(':num', '([0-9]+)', $route));
            }

            if (preg_match('#^'.$route.'$#', $url)) {
                if (strpos($uri, '$') !== false && strpos($route, '(') !== false) {
                    $uri = preg_replace('#^'.$route.'$#', $uri, $url);
                }
                $this->parameters = $this->assemble($uri);

                break;
            }
        }

        return $this->executeAction();
    }

    public function executeAction() {
        $controller = isset($this->parameters[0]) ? $this->parameters[0]: 'MainController';
        $action = isset($this->parameters[1]) ? $this->parameters[1]: 'notFound';
        $params = array_slice($this->parameters, 2);

//        var_dump(array($controller, $action));
        return call_user_func_array(array('Controllers\\' . $controller, $action), $params);
    }

}