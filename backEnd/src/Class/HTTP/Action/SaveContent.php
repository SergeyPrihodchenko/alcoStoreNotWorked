<?php

namespace Alco\Gallery\Class\HTTP\Action;

use Alco\Gallery\Class\Drinks\Drink;
use Alco\Gallery\Class\HTTP\Request\Request;
use Alco\Gallery\Class\HTTP\Response\Response;
use Alco\Gallery\Class\HTTP\Response\ErrorResponse;
use Alco\Gallery\Class\HTTP\Response\SuccessfulResponse;
use Alco\Gallery\Class\Repository\DrinksRepository;
use Alco\Gallery\Class\Repository\TokensRepository;
use Alco\Gallery\Class\Token\Token;
use DateTimeImmutable;
use Exception;

class AddContent {

    private string $authToken;
    
    function __construct(
        private DrinksRepository $repository,
        private TokensRepository $tokenRepository,
        private Token $token
    )
    {
        $this->authToken = $_COOKIE['TokenSet'];
    }

    public function handle(Request $request): Response
    {

        try {
            $token = $this->tokenRepository->getToken($_COOKIE['TokenSet']);
            if($token->expiresOn() <= new DateTimeImmutable()) {
                return new ErrorResponse('!!!!!!!!!!!!!');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage()); 
        }


        
        try {
            $name_drink = $request->jsonBodyField('name_drink');
            $description = $request->jsonBodyField('description_drink');
            $name_file = $request->jsonBodyField('name_file');
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }

            $name_drink = trim($name_drink);
            $name_drink = strip_tags($name_drink);
            $description = trim($description);
            $description = strip_tags($description);
            $name_file = trim($name_file);
            $name_file = strip_tags($name_file);

            $drink = new Drink($name_drink, $description, $name_file);

            try {
                $this->repository->save($drink);
            } catch (Exception $e) {
                return new ErrorResponse($e->getMessage());
            }

            return new SuccessfulResponse(['result' => 'ok']);
    }

}

