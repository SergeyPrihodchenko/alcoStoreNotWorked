<?php

namespace Alco\Gallery\Class\Token;

class Token {
    function __construct(
        private string $token,
        private string $name,
        private int $id_user,
        private string $expiresOn
    )
    {    
    }

    public function token(): string
    {
        return $this->token;
    }

    public function name(): string 
    {
        return $this->name;
    }

    public function id(): int
    {
        return $this->id_user;
    }

    public function expiresOn(): string
    {
        return $this->expiresOn;
    }
}