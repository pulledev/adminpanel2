<?php
declare(strict_types=1);

namespace Pulle\Crusader\Auth;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Pulle\Crusader\Auth\TemplateRendererInterface;

class Logout
{
    public function __construct(
        private readonly TemplateRendererInterface $renderer
    )
    {
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {

        //$name = $_SESSION['userName'];

        

        $body = $this->renderer->render('welcome', [
            'MOTD' => 'See you soon'
        ]);

        //session_unset();
        //session_destroy();

        $response = new Response;
        $response->getBody()->write($body);
        return $response;
    }
}