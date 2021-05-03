<?php

namespace controller;
use db, Dispatch;
use JetBrains\PhpStorm\NoReturn;

class DeleteController extends AbstractController
{
    #[NoReturn] public function doAction(bool $isBack = False) : void
    {
        $this->doJob();
    }

    #[NoReturn] protected function doJob()
    {
        $id = Dispatch\Dispatcher::getInstance()->getRoute()->getParam('id');

        $a = new db\DBDriver();
        $a -> delete("film", $id);
        header("Location:" . "/add");
    }
}