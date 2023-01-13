<?php

namespace Alco\Gallery\Class\Users;

class User {
    
    private int $id;

    function __construct(
        private string $name,
        private string $hashPassord
    )
    {
        
    }

    public function getId($id) {
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }

    public function name(): string 
    {
        return $this->name;
    }

    public function hashPassord(): string 
    {
        return $this->hashPassord;
    }

    public static function HashPassword($password): string
    {
        return hash('sha3-256', $password);
    }

    static function createUser($name, $password): User
    {
        $hashPassord = User::HashPassword($password);
        return new User($name, $hashPassord);
    } 
}
