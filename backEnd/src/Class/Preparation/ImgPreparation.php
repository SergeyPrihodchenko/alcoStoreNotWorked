<?php

namespace Alco\Gallery\Class\Preparation;

use Exception;

class ImgPreparation {

    function __construct(
        private array $imgData
    )
    {
    }

    public function name(): string
    {
        return $this->imgData['name'];
    }

    public function type(): string
    {
        return $this->imgData['type'];
    }

    public function uploadImage($name) {
        if($this->imgData[$name]['size'] > 35000) {
            throw new Exception("file size exceeds with maximum size");
        }
        $uploadfile = 'images/' . basename($_FILES[$name]['name']);
        $split_filename = explode('.', $uploadfile);
        $extension = end($split_filename);
        $array_ext_access = array('', 'jpg', 'img', 'imgs', 'png', 'bmp');
        $is_check = array_search($extension, $array_ext_access);
        if($is_check) {
        if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile)) {
            return $_FILES[$name]['name'];
        } 
    }
    }
}
