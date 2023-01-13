<?php

namespace Alco\Gallery\Class\HTTP\Action;

use Alco\Gallery\Class\HTTP\Request\Request;
use Alco\Gallery\Class\HTTP\Response\Response;
use Alco\Gallery\Class\HTTP\Response\ErrorResponse;
use Alco\Gallery\Class\Repository\TokensRepository;
use Alco\Gallery\Class\Repository\UsersRepository;
use Alco\Gallery\Class\Token\Token;
use DateTimeImmutable;
use Exception;

class Authentication {

    function __construct(
        private UsersRepository $userRepository,
        private TokensRepository $tokensRepository
    )
    {
        
    }

    public function handle(Request $request): Response
    {
        try {
            $name = $request->jsonBodyField('name');
            $password = $request->jsonBodyField('password');
        } catch (Exception $e) {
            return new ErrorResponse(new Exception("Not entert name or password"));
        }

            $name = strip_tags(trim($name));
            $password = strip_tags(trim($password));

        try {
            $user = $this->userRepository->getUser($password);
        } catch (Exception $e) {
            return new ErrorResponse(new Exception("Cannot your passwprd"));
        }

        try {
            $token = bin2hex(random_bytes(40));
            $this->tokensRepository->save(
                new Token(
                    $token,
                     $user->name(),
                     $user->id(),
                     (new DateTimeImmutable())->modify('+7 day')
                    ));
        } catch (Exception $e) {
            return new ErrorResponse(new Exception($e->getMessage()));
        }
            

        setcookie("TokenSet", $token, time()+3600);
    }
}