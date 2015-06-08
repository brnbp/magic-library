<?php

use Phalcon\Mvc\Controller;

class UserController extends \Phalcon\Mvc\Controller
{

	public function onConstruct()
	{
		if ($this->session->has("user_name") == false) {
            $this->dispatcher->forward(array(
                "controller" => "sign",
                "action" => "index"
            ));
        }
	}

    public function indexAction()
    {
		echo 'indexAction';

        //printrx(43543);
        
    }

    public function wishlistAction()
    {
        $this->dispatcher->setParams(array('wishlist' => true));
        $this->dispatcher->forward(array(
            "controller" => "cards",
            "action" => "index"
        ));
    }

    public function grimorioAction()
    {
    	echo 'grimorioAction';
    }


}