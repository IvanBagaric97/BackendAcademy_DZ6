<?php

namespace Routing;

use \Symfony\Component\Yaml\Yaml;
use lib;

class DefaultRoute extends Route
{

    public static string $PATTERN = "/<[a-z0-9_]+>/iu";

    /** @var  string */
    public string $match_regex;

    /** @var  string */
    public string $regex;

    /** @var  string */
    public string $controller;

    /** @var  string */
    public string $action;

    /** @var  array */
    public array $default_params;

    /** @var  array */
    public array $params;

    /** @var  bool */
    public bool $remember;

    /** @var  string */
    public string $access;

    /**
     * @param array $route
     * @return DefaultRoute
     */
    private static function fromYML(array $route): DefaultRoute
    {
        return new DefaultRoute(
            lib\element('url', $route, ''),
            lib\element('controller', $route, ''),
            lib\element('action', $route, ''),
            lib\element('remember', $route, false),
            intval(lib\element('access', $route, 0)),
            lib\element('defaults', $route, []),
            lib\element('regexs', $route, [])
        );
    }

    /**
     * @param string $path path to file
     */
    public static function registerFromYML(string $path)
    {
        $routes = Yaml::parse(file_get_contents($path));

        foreach ($routes as $route_name => $r) {
            $route = DefaultRoute::fromYML($r);
            self::register($route_name, $route);
        }
    }

    /**
     * @param string $url
     * @param string $controller
     * @param string $action
     * @param bool $remember
     * @param string $access
     * @param array $defaults
     * @param array $regexs
     */
    private function __construct(string $url, string $controller, string $action, bool $remember, string $access, $defaults = [], $regexs = [])
    {
        $f = function ($match) use ($regexs) {
            $name = substr($match[0], 1, -1); // take the name
            $reg = lib\element($name, $regexs, ".+?");
            return "(?P" . $match[0] . $reg . ")";
        };

        $this->regex = '/' . $url;
        $this->match_regex = "@^" . preg_replace_callback(self::$PATTERN, $f, $this->regex) . "$@uD";

        $this->remember = $remember;
        $this->access = $access;

        $this->controller = $controller;
        $this->action = $action;
        $this->default_params = $defaults;
        $this->params = [];
    }


    public function matches(string $url): bool
    {
        return (bool)preg_match($this->match_regex, $url, $this->params);
    }

    public function generate($params = []): string
    {
        $params = array_merge($this->default_params, $params);
        $f = function ($match) use ($params) {
            $name = substr($match[0], 1, -1); // take the name
            $reg = lib\element($name, $params, null);
            if ($reg == null) throw new RoutingException("Parameter $name wasn't provided");
            return $reg;
        };

        return preg_replace_callback(self::$PATTERN, $f, $this->regex);
    }

    public function getParam(string $key, $default = ""): string
    {
        return lib\element($key, $this->params, $default);
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getRemember(): bool
    {
        return $this->remember;
    }

    public function getAccess(): bool
    {
        return $this->access;
    }

}


