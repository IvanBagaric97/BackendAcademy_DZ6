<?php

namespace controller;

use view, db, Dispatch;


class IndexController extends AbstractController
{

    public function doAction(bool $isBack = False) : void
    {
        parent::doAction($isBack);
        $this -> doJob();
    }

    protected function doJob()
    {
        $a = new db\DBDriver();
        $letter = Dispatch\Dispatcher::getInstance()->getRoute()->getParam('let');

        if($letter !== null & $letter !== ""){
            if(in_array(strtoupper($letter), range("A", "Z"))) {
                $collection = $a->startsWithLetter($letter);
                if (empty($collection)) {
                    $h3 = new view\ErrorView("No movies with letter " . $letter);
                } else {
                    $h3 = new view\FilmTitleView($collection);
                }
            }else{
                $h3 = new view\ErrorView("User entered " . $letter . " instead of a letter");
            }
            $h3->generateHTML();
        }
    }
}