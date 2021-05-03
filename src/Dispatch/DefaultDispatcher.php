<?php

namespace Dispatch;

use controller\AbstractController;
use Routing\Route;
use Routing\RoutingException;

class DefaultDispatcher extends Dispatcher
{

    /** @var  ?Route */
    private ?Route $route = null;

    public function dispatch()
    {
        $uri = $_SERVER["REQUEST_URI"];
        if (($pos = strpos($uri, '?')) !== false)
            $uri = substr($uri, 0, $pos);

        /** @var Route $r */
        foreach (Route::get() as $r) {
            if ($r->matches($uri)) {
                $this->route = $r;
                break;
            }
        }

        if ($this->route == null) throw new RoutingException("Route for $uri not found");

        $ctl = $this->route->getController();
        $ctlCls = "\\Controller\\" . implode('\\', array_map('ucfirst', explode('/', $ctl)));
        if (!class_exists($ctlCls)) throw new RoutingException("Controller $ctl not found");

        /** @var AbstractController $controler */
        $controler = new $ctlCls();

        $action = $this->route->getAction();
        if (!is_callable([$controler, $action]))
            throw new RoutingException("Action $action not found in controller $ctl");

        $controler->$action();
    }

    public function getRoute(): Route
    {
        return $this->route;
    }
}