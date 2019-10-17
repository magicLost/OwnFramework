<?php

use Symfony\Component\Routing\{
    RouteCollection,
    Route
};

$routes = new RouteCollection();

$routes->add('hello', new Route('/hello/{name}', ['name' => 'World']));

$routes->add('bye', new Route('/bye'));

return $routes;