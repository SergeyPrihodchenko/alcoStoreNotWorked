<?php

namespace Alco\Gallery\Class\Repository;

use Alco\Gallery\Class\Token\Token;
use Exception;
use PDO;

class TokensRepository {

    function __construct(
        private PDO $connect
    )
    {
    }

    public function save(Token $token): void
    {
        try {
            $statement = $this->connect->prepare("INSERT INTO token (token, name, expires_on) VALUES (:token, :name, expires_on) ON CONFLICT (token) DO UPDATE SET expires_on = :expires_on;");
            $statement->execute([
                ':token' => $token->token(),
                ':name' => $token->name(),
                ':expires_on' => $token->expiresOn()
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getToken($token): Token
    {
        try {
            $statement = $this->connect->query("SELECT * FROM token WHERE token = $token");
            $dataToken = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($e->getMessage()); 
        }
        return new Token($dataToken['token'], $dataToken['name'], $dataToken['id_user'], $dataToken['expiresOn']);
    }

}

