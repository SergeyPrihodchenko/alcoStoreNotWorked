<?php

namespace Alco\Gallery\Class\Repository;

use Alco\Gallery\Class\Token\Token;
use DateTimeImmutable;
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

            $query = <<<'SQL'
            INSERT INTO token (
                token,
                name,
                expires_on,
                id_user
            ) VALUES (
                :token,
                :name,
                :expires_on,
                :id_user
            )
            ON CONFLICT (token) DO UPDATE SET
            expires_on = :expires_on
        SQL;

            $statement = $this->connect->prepare($query);
            $statement->execute([
                ':token' => $token->token(),
                ':name' => $token->name(),
                ':expires_on' => $token->expiresOn()->format(DateTimeImmutable::ATOM),
                ':id_user' => $token->id()
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getToken($token): Token
    {
        try {
            $statement = $this->connect->query("SELECT * FROM token WHERE token = '$token';");
            $dataToken = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($token); 
        }
        return new Token($dataToken['token'], $dataToken['name'], $dataToken['id_user'], new DateTimeImmutable($dataToken['expires_on']));
    }

}

