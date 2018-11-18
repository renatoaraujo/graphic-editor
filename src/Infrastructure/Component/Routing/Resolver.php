<?php

namespace GraphicEditor\Infrastructure\Component\Routing;

use GraphicEditor\Infrastructure\Component\DependencyInjection\Container;
use GraphicEditor\Infrastructure\Component\Routing\Exception\RouteNotFoundException;

final class Resolver
{
    public function __invoke(Container $container)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $request = \parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $route = $this->getMatchingRoute($request, $method);

        if (empty($route)) {
            throw new RouteNotFoundException(
                \sprintf('Route with name %s and method %s not found.', $request, $method)
            );
        }

        $route = \array_shift($route);
        $callable = $route['controller'];

        $controller = $container->get($callable);

        return $controller(Request::fromRawJson(\file_get_contents('php://input')), true);
    }

    private function getMatchingRoute($request, $method)
    {
        $file = ROOT_PATH . '/config/routes.yml';

        if (!\file_exists($file)) {
            throw new \Exception(
                \sprintf('Config file not found in %s', $file)
            );
        }

        $routes = \yaml_parse_file($file);

        return \array_filter($routes, function ($route) use ($request, $method) {
            if ($route['path'] === $request && $route['method'] === $method) {
                return $route;
            }
        });
    }
}
