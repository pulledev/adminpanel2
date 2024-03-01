<?php


use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\RouteCollectionInterface;
use League\Route\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Pulle\Crusader\Logger\Log;
use Pulle\Crusader\Renderer\MustacheTemplateRenderer;
use Pulle\Crusader\Renderer\TemplateRendererInterface;


return [
    'templatePath' => __DIR__.'/templates',

    ServerRequestInterface::class => function(){
        return ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
        );
    },
    RouteCollectionInterface::class => function(ContainerInterface $container){
        $strategy = (new League\Route\Strategy\ApplicationStrategy)->setContainer($container);
        return (new Router())->setStrategy($strategy);
    },
    EmitterInterface::class => function(){
        return new SapiEmitter();
    },
    TemplateRendererInterface::class => function(ContainerInterface $container)
    {
        $mustache = new Mustache_Engine([
           'loader' => new Mustache_Loader_FilesystemLoader($container->get('templatePath')),
            'partials_loader' => new Mustache_Loader_FilesystemLoader($container->get('templatePath')),
            'escape' => function ($value){
                return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
            }
        ]);
        return new MustacheTemplateRenderer($mustache);
    },
    PDO::class => function(ContainerInterface $container)
    {
        $servername = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        $dbport = $_ENV['DB_PORT']??3306;
        $dbcharset = $_ENV['DB_CHARSET']??'utf8';

        $dsn = "mysql:host=$servername;port=$dbport;dbname=$dbname";

        return new PDO($dsn, $username, $password);
    },
    Log::class => function(ContainerInterface $container)
    {
        return new Pulle\Crusader\Logger\Log();
    }
];


