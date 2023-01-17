<?php

namespace Alco\Gallery\Class\HTTP\Action;

use Alco\Gallery\Class\HTTP\Request\Request;
use Alco\Gallery\Class\HTTP\Response\ErrorResponse;
use Alco\Gallery\Class\HTTP\Response\Response;
use Alco\Gallery\Class\HTTP\Response\SuccessfulResponse;
use Alco\Gallery\Class\Repository\TokensRepository;
use DateTimeImmutable;
use Exception;

class AuthenticationToken {

    function __construct(
        private TokensRepository $repository
    )
    {
        
    }

    public function handle(Request $request): Response {
        
        try {
            $token = $request->jsonbodyField('token');
            $db_token = $this->repository->getToken($token);
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }
        try {
            $date = (new DateTimeImmutable())->format(DateTimeImmutable::ATOM);
        if($db_token->expiresOn() <= $date) {
            setcookie('token', null, time()-3600 * 24);
            return new ErrorResponse('Retry sign in');
        }
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }

        

        return new SuccessfulResponse(['result' => 'ok']);
    }
}