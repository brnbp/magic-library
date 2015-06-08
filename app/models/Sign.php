<?php

use Phalcon\Mvc\Model;

/**
 * Responsavel por manipular informações de usuario no banco
 *  referente a login, logout e logup
 */ 
class Sign extends \Phalcon\Mvc\Model
{	
    /** Object Connection Database */
    private $db;

    /**
     * Set Database Connection to Class Model Sign
     * @param Object $db
     */ 
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * Get all Users from usuarios table on database
     * @return array $users with all users with all columns from usuarios database
     */ 
	public function getUsuarios()
	{
    	$users = $this->db->fetchAll("select * from usuarios", Phalcon\Db::FETCH_ASSOC);
    	return $users;
	}

    /**
     * Get User by Login or Senha
     * @param array $params with login or email data and password data to research
     * @return array $resultQuery with all columns from usuarios table related with user $params
     */ 
	public function getUsuarioByLoginSenha($params)
	{
        $query = "SELECT * FROM usuarios where ";
        $query .= "login = '{$params[login_email]}' or email = '{$params[login_email]}' ";
        $query .= "and password = '{$params[password]}' ";
        $resultQuery = $this->db->fetchOne($query, Phalcon\Db::FETCH_ASSOC);

        return $resultQuery;
	}

    /**
     * Insert new user info to usuarios database, if he does not exists already
     * @param array $params with all input data from register form
     * @return string | integer string with info with error or integer id of new user
     */ 
    public function registerUser($params)
    {
        if ($this->verifyExistsUserByLoginOrEmail($params) != false) {
            return 'exists';
        }

        $query = "INSERT INTO usuarios(name, email, login, password) ";
        $query .= "values('$params[name]', '$params[email]', '$params[login]', '$params[password]')";
        $newUser = $this->db->query($query);

        if ($newUser->numRows() > 0) {
            return $this->verifyExistsUserByLoginOrEmail($params);
        }

        return 'temporary_error';
    }

    /**
    *   Verifica a existencia de usuario pelo login ou email informado
    *   @param array contendo login e email informados no cadastro
    *   @return boolean true se existe ou false se nao existe
    */
    private function verifyExistsUserByLoginOrEmail($params)
    {
        $query = "SELECT id FROM usuarios where login = '{$params[login]}' or email = '{$params[email]}' ";
        $resultQuery = $this->db->fetchOne($query, Phalcon\Db::FETCH_ASSOC);

        if(isset($resultQuery['id']) && strlen($resultQuery['id']) > 0) {
            return (int) $resultQuery['id'];
        }

        return false;
    }

    /**
     * Set 1 for user that has login in the site and update logado_em column of table
     * @param string $id_user
     */ 
    public function setUserLogged($id_user)
    {
        $this->db->query("UPDATE usuarios set logado = '1', logado_em = NOW() where id = '$id_user' ");
    }

    /**
     * Set 0 for user that has logout in the site
     * @param string $id_user
     */ 
    public function setUserUnlogged($id_user)
    {
        $this->db->query("UPDATE usuarios set logado = '0' where id = '$id_user' ");
    }

}