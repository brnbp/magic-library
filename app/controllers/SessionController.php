<?php

use Phalcon\Mvc\Controller;

class SessionController extends \Phalcon\Mvc\Controller
{
    private $hasSession = 0;

    public function onConstruct()
    {
        
    }

	public function indexAction()
    {
    }

    public function hasSession()
    {   
        
        //printr($this->session);
    }
}