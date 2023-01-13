<?php

namespace Alco\Gallery\Class\HTTP\Action;

use Alco\Gallery\Class\HTTP\Request\Request;
use Alco\Gallery\Class\HTTP\Response\Response;
use Alco\Gallery\Class\HTTP\Response\ErrorResponse;
use Alco\Gallery\Class\HTTP\Response\SuccessfulResponse;
use Alco\Gallery\Class\Preparation\ImgPreparation;
use Alco\Gallery\Class\Repository\TokensRepository;
use Alco\Gallery\Class\Token\Token;
use DateTimeImmutable;
use Exception;

class SaveFileIMG {

    private array $file;

    function __construct(
        private TokensRepository $tokenRepository,
        private Token $token
    )
    {
        $this->file = $_FILES;
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
            $file = new ImgPreparation($this->file['img_file']);
            $file->uploadImage('img_file');
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessfulResponse(['img_file' => 'img saved in directory']);
    }
}