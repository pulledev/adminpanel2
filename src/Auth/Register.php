<?php
declare(strict_types=1);

namespace Pulle\Crusader\Auth;

use Laminas\Diactoros\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Pulle\Crusader\Database\DatabaseUtility;
use Pulle\Crusader\Database\UserPDO;
use Pulle\Crusader\Renderer\TemplateRendererInterface;

class Register
{

    public function __construct(
        private readonly TemplateRendererInterface $renderer,
        private readonly RegistrationValidator $validator,
        private readonly UserPDO $userPDO, private readonly DatabaseUtility $databaseUtility

    ){

    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {

        $post = false;
        if ($request->getMethod() === 'POST')
        {
            $body = $request->getParsedBody();
            $post = true;
        }

        $username = $body['username']??'';
        $password = $body['password']??'';
        $password2 = $body['password2']??'';
        $rank = $body['rank']??'';

        if ($this->validator->isValid($username, $password, $password2))
        {
            $rank = (int)$rank;
            $salt = $this->databaseUtility->generateSalt();
            $hashPassword = $this->databaseUtility->hashPassword($password);
            $this->userPDO->registerUser($username, $hashPassword, $salt, $rank);
            return new Response\RedirectResponse('/');
        }

        $error = $this->validator->getErrors($post);

        $body = $this->renderer->render('register', [
            'username' => $username,
            'password' => $password,
            'passwordRepeat' => $password2,
            'errors' => $error
        ]);



        $response = new Response;
        $response->getBody()->write($body);
        return $response;
    }
}