<?php

namespace Alco\Gallery\Class\HTTP\Response;

abstract class Response {

    protected const SUCCESS = true;

    public function send(): void 
    {
        $data = ['success' => static::SUCCESS] + $this->payload();

        header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE, GET, POST');
header('Access-Control-Request-Headers: X-Custom-Header');
        header('Content-Type: application/json');

        echo json_encode($data, JSON_THROW_ON_ERROR);
    }

    abstract protected function payload(): array;
}