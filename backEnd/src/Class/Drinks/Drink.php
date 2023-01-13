<?php

namespace Alco\Gallery\Class\Drinks;

class Drink {

    function __construct(
        public string $name,
        public string $description,
        public string $img_name
    )
    {   
    }
}