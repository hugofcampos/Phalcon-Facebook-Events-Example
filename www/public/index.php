<?php

require __DIR__ . '/../vendor/autoload.php';

try {

    $config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');

    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/',
        '../app/libraries/'
    ))->registerNamespaces(array(
        'FBEvents\Controllers' => '../app/controllers',
        'FBEvents\Libraries\Facebook' => '../app/libraries/Facebook'
    ))->register();

    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();

    $di->setShared('config', $config);

    //Setup the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });

    //Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/');
        return $url;
    });

    $di->set('router', function() {
        $router = new Phalcon\Mvc\Router(false);
        $router->add(
            '/', array(
            'controller' => 'FBEvents\Controllers\Index',
            'action' => 'index'
        ));
        return $router;
    }, true);

    //Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}