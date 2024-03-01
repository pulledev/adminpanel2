<?php

declare(strict_types=1);
session_start();
//Autoloader is loaded
require_once "vendor/autoload.php";


use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use League\Route\RouteCollectionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Pulle\Crusader\Auth\Register;
use Pulle\Crusader\Auth\Login;

//.env file is initiated and is loaded
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//DI Container is initalized
$builder = new \DI\ContainerBuilder();

//Load Dependencies
$builder->addDefinitions(__DIR__.'/dependencies.php');

$container = $builder->build();


$router = $container->get(RouteCollectionInterface::class);
$request = $container->get(ServerRequestInterface::class);
$emitter = $container->get(EmitterInterface::class);

// map a route
$router->map('GET', '/', function (ServerRequestInterface $request) use($container): ResponseInterface {

    $renderer = $container->get(\Pulle\Crusader\Renderer\TemplateRendererInterface::class);
    $body = $renderer->render('index', ['test' => 'Hello World 2']);

    $response = new Laminas\Diactoros\Response;
    $response->getBody()->write($body);
    return $response;
});

//Routing for register page
$router->map('GET', '/account/create', Register::class);
$router->map('POST', '/account/create', Register::class);

//Routing for login page
$router->map('GET', '/account/login', Login::class);
$router->map('POST', '/account/login', Login::class);

$router->map('GET', '/account/logout', \SchoolExchange\Core\Auth\Logout::class);



$response = $router->dispatch($request);

// send the response to the browser
$emitter->emit($response);