<?php

use Phalcon\Mvc\Model;

class Users extends \Phalcon\Mvc\Model
{	

    private $db;

    public function getDb($db)
    {
        $this->db = $db;
    }

	public function in()
	{
		echo 'model loaded<hr>';
	}

	public function out()
	{
		echo "<hr>bye<hr>";
	}
}