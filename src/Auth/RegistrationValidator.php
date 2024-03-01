<?php
declare(strict_types=1);

namespace Pulle\Crusader\Auth;

class RegistrationValidator
{
    private array $errors = [];
    public function isValid(string $username, string $password, string $password2): bool{

        //check that nothing is too short
        if(mb_strlen($username) < 4) {
            $this->errors[] = 'Username is to short (min. 4 letters)';
        }


        //check that nothing is empty or invalid
        if (empty($username)){
            $this->errors[] = 'Username is empty';
        }

        if (empty($password)){
            $this->errors[] = 'Password is empty';
        }
        if (empty($password2)){
            $this->errors[] = 'Repeated password is empty';
        }

        if (mb_strlen($password2) < 3){
            $this->errors[] = 'Password is too short (min. 8 letters)';
        }

        //check that password and password2 are the same
        if($password !== $password2){
            $this->errors[] = 'The passwords mismatch';
        }

        return count($this->errors) === 0;
    }
    public function getErrors(bool $post): ?array
    {
        if (!$post){
            return null;
        }
        return $this->errors;
    }
}