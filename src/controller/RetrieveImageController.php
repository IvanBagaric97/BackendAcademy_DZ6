<?php

namespace controller;
use db, Dispatch;

class RetrieveImageController extends AbstractController
{

    public function doAction(bool $isBack = False) : void
    {
        $this -> doJob();
    }

    protected function doJob()
    {
        $a = new db\DBDriver();
        $id = Dispatch\Dispatcher::getInstance()->getRoute()->getParam('id');
        $src = $a -> getImage($id);

        $array = explode(".", $src);
        $fileType = end($array);

        $format = "Content-Type: image/" . $fileType;
        header($format);

        switch($fileType) {
            case "jpg":
            case "jpeg":
                $im = imagecreatefromjpeg($src);
                imagejpeg($im);
                break;
            case "png":
                $im = imagecreatefrompng($src);
                imagepng($im);
                break;
            case "gif":
                $im = imagecreatefromgif($src);
                imagegif($im);
                break;
            default:
                $im = imagecreatefrompng($src);
                imagepng($im);
        }

        imagedestroy($im);
    }
}