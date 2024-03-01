<?php
declare(strict_types=1);

namespace Pulle\Crusader\Auth;

class User
{
    private string $username;
    private int $id;
    private int $rank;
    private string $password;

    /**
     * @param string $username
     * @param int $id
     * @param int $rank
     * @param string $password
     */
    public function __construct(string $username, int $id, int $rank, string $password)
    {
        $this->username = $username;
        $this->id = $id;
        $this->rank = $rank;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getRank(): int
    {
        return $this->rank;
    }




}