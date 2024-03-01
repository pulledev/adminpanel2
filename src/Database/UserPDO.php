<?php
declare(strict_types=1);

namespace Pulle\Crusader\Database;

use Pulle\Crusader\Auth\User;
use Pulle\Crusader\Database\DatabaseUtility;
use PDO;
use PDOException;

class UserPDO
{
    public function __construct(
        private readonly PDO             $connection,
        private readonly DatabaseUtility $databaseUtility
    )
    {
    }

    public function registerUser(string $username, string $passwordHash, string $salt, int $rank)
    {

        $time = date('Y-m-d H:i:s');
        $stmt = $this->connection->prepare("INSERT INTO user (username, password, salt, rank) VALUES (:username, :password, :salt, :rank)");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $passwordHash);
        $stmt->bindParam(":salt", $salt);
        $stmt->bindParam(":rank", $rank);
        $stmt->execute();
    }

    /*public function checkUserLogin(string $email, string $password): ?User
    {

        $stmt = $this->connection->prepare("SELECT id, username, email, createdAt, rank, updatedAt FROM user WHERE email =:email AND passwordHash=:passwordHash");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(":passwordHash", $password, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();

        if($result){
            return new User($result["username"], $result["id"], $result["rank"], $result["email"], $result["createdAt"]);
        }
        return null;
    }*/

    public function checkUserByName(string $username): ?User
    {

        $stmt = $this->connection->prepare("SELECT id, username, rank, password FROM user WHERE username=:username");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();

        if($result){
            return new User($result["username"], $result["id"], $result["rank"], $result["password"]);
        }
        return null;
    }


}