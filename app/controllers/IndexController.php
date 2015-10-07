<?php

use Phalcon\Mvc\Controller,
    Phalcon\Mvc\View;

class IndexController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {   
        $decksModel = new Cards();
        $decksModel->setDb($this->db);
        $allCollections = $decksModel->getDecks();

        $this->view->setVar("allCollections", $allCollections);

    	//$this->view->disable();
    }

    public function show404Action()
    {
        echo '<br><br><br> oi, nao existo :( ';
        $this->view->disable();
    }

}