<?php
declare(strict_types=1);

namespace Pulle\Crusader\Auth;

use Laminas\Diactoros\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Pulle\Crusader\Database\DatabaseUtility;
use Pulle\Crusader\Database\UserPDO;
use Pulle\Crusader\Logger\Log;
use Pulle\Crusader\Renderer\TemplateRendererInterface;

class Login
{
    public function __construct(
        private readonly TemplateRendererInterface $renderer,
        private readonly LoginValidator $validator,
        private readonly Log $log
    )
    {
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {

        if ($request->getMethod() === 'POST')
        {
            $body = $request->getParsedBody();

            $post = true;
            $username = $body['username'];
            $password = $body['password'];

            if ($this->validator->isValid($username, $password))
            {
                $this->log->processLog()->info("Log In");
                return new Response\RedirectResponse('/');
            }
        }


        echo "lol";





        $response = new Response;
        $response->getBody()->write($body);
        return $response;
    }

}