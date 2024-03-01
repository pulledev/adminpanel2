<?php
declare(strict_types=1);

namespace Pulle\Crusader\Auth;

use PDO;
use Pulle\Crusader\Database\DatabaseUtility;
use Pulle\Crusader\Database\UserPDO;
use Pulle\Crusader\Auth\User;

class LoginValidator
{

    public User $activeUser;
    public array $errors = [];

    function __construct(
        private readonly UserPDO         $userPDO,
        private readonly DatabaseUtility $databaseUtility
    )
    {
    }

    public function isValid(string $username, string $password): bool
    {

        $nameUser = $this->userPDO->checkUserByName($username);

        if ($nameUser != null) {
            $passwordValid = $this->databaseUtility->verifyPassword($password, $nameUser->getPassword());
            if($passwordValid) {
                $this->activeUser = $nameUser;
                $this->safeActiveUser();
                return true;
            }else{
                return false;
            }

        }
        return count($this->errors) == 0;
    }

    public function getUser(bool $post): ?User
    {
        if (!$post) {
            return null;
        }
        return $this->activeUser;
    }

    public function getErrors(bool $post): ?array
    {
        if (!$post) {
            return null;
        }
        return $this->errors;
    }

    public function safeActiveUser(): void
    {
        $_SESSION["userId"] = $this->activeUser->getId();
        $_SESSION["userRank"] = $this->activeUser->getRank();
        $_SESSION["userRank"] = $this->activeUser->getRank();
        $_SESSION["userName"] = $this->activeUser->getUsername();
    }
    public function isUserLoggedIn()
    {

    }

}