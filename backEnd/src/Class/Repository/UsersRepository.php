<?php

namespace Alco\Gallery\Class\Repository;

use Alco\Gallery\Class\Users\User;
use Exception;
use PDO;

class UsersRepository {

    function __construct(
       private PDO $connect
    )
    {
    }

    public function save(User $user): void
    {
        try {
            $statement = $this->connect->prepare("INSERT INTO Users (name, password) VALUES (:name, :hashPassord);");
            $statement->execute(
                [
                    ':name' => $user->name(),
                    ':hashPassord' => $user->hashPassord()
                ]
                );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getUser($password): User
    {
        try {
            $statement = $this->connect->prepare("SELECT * FROM users WHERE password = :hashPassord");
            $statement->execute([
                'hashPassord' => $password
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
            $user =  new User($result['name'], $result['password']);
            $user->getId($result['id_user']);
            return $user;
    }
}