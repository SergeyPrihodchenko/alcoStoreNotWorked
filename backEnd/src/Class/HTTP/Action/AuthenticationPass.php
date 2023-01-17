<?php

namespace Alco\Gallery\Class\HTTP\Action;

use Alco\Gallery\Class\HTTP\Request\Request;
use Alco\Gallery\Class\HTTP\Response\Response;
use Alco\Gallery\Class\HTTP\Response\ErrorResponse;
use Alco\Gallery\Class\HTTP\Response\SuccessfulResponse;
use Alco\Gallery\Class\Repository\TokensRepository;
use Alco\Gallery\Class\Repository\UsersRepository;
use Alco\Gallery\Class\Token\Token;
use Alco\Gallery\Class\Users\User;
use DateTimeImmutable;
use Exception;

class AuthenticationPass {

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
            $password = User::HashPassword(strip_tags(trim($password)));
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
            return new ErrorResponse($e->getMessage());
        }
      
        setcookie("TokenSet", $token, [
            'expires' => time() + 3600 * 24 * 5,
            'samesite' => 'Strict'
        ]);
        
        return new SuccessfulResponse([
            'result' => 'ok',
            'token' => $token
        ]);
    }
}