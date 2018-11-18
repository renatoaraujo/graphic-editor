<?php

\define('ROOT_PATH', __DIR__ . '/../.');

require_once ROOT_PATH . '/vendor/autoload.php';

$routingResolver = new \GraphicEditor\Infrastructure\Component\Routing\Resolver;
$container = new \GraphicEditor\Infrastructure\Component\DependencyInjection\Container();

try {
    $routingResolver($container);
} catch (\Exception $exception) {
    new \GraphicEditor\Infrastructure\Component\Routing\JsonResponse(
        ['success' => false, 'error' => ['message' => $exception->getMessage()]],
        $exception->getCode()
    );
}
