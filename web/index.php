<?php

//FRONT CONTROLLER
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\{
    RequestContext,
    Matcher\UrlMatcher,
    Exception\ResourceNotFoundException
};

function render_template($request){

    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    /** @var string $_route */
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    return new Response(ob_get_clean());
}


$request = Request::createFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

try{

    $request->attributes->add($matcher->match($request->getPathInfo()));
    $response = call_user_func($request->attributes->get('_controller'), $request);

}catch(ResourceNotFoundException $exception){
    $response = new Response('Not Found', 404);
}catch(Exception $exception){
    $response = new Response('An error occurred', 500);
}

$response->send();


