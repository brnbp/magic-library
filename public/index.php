<?php

require_once('../app/helper/helper.php');
require_once('../app/system/Template.php');
require_once('../app/bootstrap.php');

use Phalcon\Session\Adapter\Files as Session;

try {

    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/'
    ))->register();

    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();

    //Setting up the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });

   $di->set('db', function(){
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
                'host' => 'localhost',
                'username' => 'root',
                'password' => 'admin',
                'dbname' => 'magic'
            ));
    });

    $di->setShared('session', function() {
        $session = new Session();
        $session->start();
        return $session;
    });

    //Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
     //return header("Location: /magicPhalcon/index/show404");
    echo "PhalconException: ", $e->getMessage();
}