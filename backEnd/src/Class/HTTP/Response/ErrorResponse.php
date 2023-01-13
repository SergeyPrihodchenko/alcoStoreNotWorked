<?php

namespace Alco\Gallery\Class\HTTP\Response;

use Alco\Gallery\Class\HTTP\Response\Response;

class ErrorResponse extends Response {

    protected const SUCCESS = false;
    
    function __construct(
        private string $reason = 'Something goes wrong'
    )
    {
        
    }

    protected function payload(): array
    {
        return ['reason' => $this->reason];
    }
}