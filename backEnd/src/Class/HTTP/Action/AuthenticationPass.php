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
            return new SuccessfulResponse(['result' => 'not', 'error' => $e->getMessage()]);
        }

        try {
            if ($token = $this->tokensRepository->getId($user->id())) {
                if($token->expiresOn()->format(DateTimeImmutable::ATOM) <= (new DateTimeImmutable())->format(DateTimeImmutable::ATOM)) {
                    
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            $newToken = bin2hex(random_bytes(40));
            $this->tokensRepository->save(
                new Token(
                    $newToken,
                     $user->name(),
                     $user->id(),
                     (new DateTimeImmutable())->modify('+7 day')
                    ));
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }
      
        setcookie("TokenSet", $newToken, [
            'expires' => time() + 3600 * 24 * 5,
            'path' => '/',
            'secure' => false,
            'httponly' => false,
            'samesite' => 'Strict'
        ]);

        
        return new SuccessfulResponse([
            'result' => 'ok',
            'token' => $token
        ]);
    }
}