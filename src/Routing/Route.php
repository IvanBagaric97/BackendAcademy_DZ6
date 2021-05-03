<?php

namespace Routing;
use lib;

abstract class Route
{

    /** @var array Routes */
    private static array $map = [];

    /**
     * Returns true if this route matches the given url.
     *
     * @param string $url
     * @return bool
     */
    public abstract function matches(string $url): bool;

    /**
     * @param array $params
     * @return string generated url
     */
    public abstract function generate($params = []): string;

    /**
     * @param string $key
     * @param string $default
     * @return string
     */
    public abstract function getParam(string $key, $default = ""): string;

    /**
     * @return string
     */
    public abstract function getController(): string;

    /**
     * @return string
     */
    public abstract function getAction(): string;

    /** @return bool */
    public abstract function getRemember(): bool;

    /** @return bool */
    public abstract function getAccess(): bool;

    /**
     * @param string $name
     * @param Route $route
     */
    public static function register(string $name, Route $route)
    {
        self::$map[$name] = $route;
    }

    /**
     * @param string|null $name
     * @return Route | array
     */
    public static function get(string $name = null): Route|array
    {
        if ($name == null) return self::$map;
        return lib\element($name, self::$map, null);
    }

}