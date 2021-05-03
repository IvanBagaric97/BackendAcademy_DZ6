<?php

namespace controller;
use view, db, lib, Dispatch;

class AddController extends AbstractController
{

    public function doAction(bool $isBack = False) : void
    {
        parent::doAction(True);
        $this  -> doJob();

    }

    protected function doJob()
    {
        $er = "";
        $a = new db\DBDriver();
        $data = $_POST;

        if(!empty($data)){
            $title = lib\post("title");
            $genre = lib\post("genre");
            $year = (int) lib\post("year");
            $duration = (int) lib\post("duration");
            $file = $_FILES["file"]["name"];

            if($title === null || $title === "") $er .= "Movie title is missing. ";
            if($genre === null) $er .= "Movie genre is missing. ";
            if($year === null) $er .= "Movie year is missing. ";
            if($duration === null || $duration === ""){
                $er .= "Duration is missing. ";
            }elseif((int)$duration > 300 || (int)$duration < 10) {
                $er .= "Movie duration is out of range.";
            }
            if($file === null) $er .= "Movie headline image is missing. ";

            if($er === ""){
                $upload_dir = "resources/";
                $uploadFile = $file;

                $array = explode(".", $uploadFile);
                $fileExtension = end($array);

                $newName = $upload_dir . "file_" . time() . "." . $fileExtension;

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $newName)) {
                    $a->createNewMovie($title, $a->getGenreId($genre), $year, $duration, $newName);
                } else {
                    echo "Datoteka nije prebacena!";
                }
            }
        }

        $h1 = new view\FormView();
        $h1 -> generateHTML();

        if($er !== ""){
            $h = new view\ErrorView($er);
            $h -> generateHTML();
            reset($_POST);
        }

        $col = $a->select("film");
        $sort = Dispatch\Dispatcher::getInstance()->getRoute()->getParam('word');
        if($sort === "title"){
            usort($col, "lib\compareName");
        }elseif($sort === "year"){
            usort($col, "lib\compareYear");
        }elseif($sort === "duration"){
            usort($col, "lib\compareDuration");
        }
        $h2 = new view\FilmTableView($col);
        $h2 -> generateHTML();
    }
}