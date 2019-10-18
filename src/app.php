<?php

use Symfony\Component\Routing\{
    RouteCollection,
    Route
};
use Symfony\Component\HttpFoundation\Response;

function is_leap_year($year = null) {
    if (null === $year) {
        $year = date('Y');
    }

    return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
}

$routes = new RouteCollection();

$routes->add('hello', new Route('/hello/{name}', [

        'name' => 'World',

        '_controller' => function($request) {

            // $foo will be available in the template
            $request->attributes->set('foo', 'bar');

            $response = render_template($request);

            // change some header
            $response->headers->set('Content-Type', 'text/plain');

            return $response;
        }
    ]));

$routes->add('bye', new Route('/bye', [

    '_controller' => function($request) {

        $response = render_template($request);

        // change some header
        //$response->headers->set('Content-Type', 'text/plain');

        return $response;
    }
]));

$routes->add('leap_year', new Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => function ($request) {
        if (is_leap_year($request->attributes->get('year'))) {
            return new Response('Yep, this is a leap year!');
        }

        return new Response('Nope, this is not a leap year.');
    }
]));

return $routes;