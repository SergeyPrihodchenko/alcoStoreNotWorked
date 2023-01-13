<?php

namespace Alco\Gallery\Class\Preparation;

class TextPreparation {
    function __construct(
        private string $name_drink,
        private string $description,
        private string $name_file
    )
    {
    }

    public function name_drink(): string
    {
        return $this->name_drink;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function name_file(): string 
    {
        return $this->name_file;
    }

    public static function preparationDescription($text) {
        return nl2br($text);
    }
}
    