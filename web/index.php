<?php

//FRONT CONTROLLER
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Simplex\Framework;
use Symfony\Component\HttpKernel\Controller\{
    ControllerResolver,
    ArgumentResolver
};
use Symfony\Component\Routing\{
    RequestContext,
    Matcher\UrlMatcher
};

/*function render_template($request){

    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    /** @var string $_route
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    return new Response(ob_get_clean());
}*/


$request = Request::createFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$framework = new Framework($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();


