<?php

namespace FBEvents\Controllers;

use FBEvents\Libraries\Facebook\User;

class IndexController extends \Phalcon\Mvc\Controller
{
  public function indexAction()
  {
    $config = array(
      'appId' => $this->config->facebookapp->appId,
      'secret' => $this->config->facebookapp->secret,
      'allowSignedRequest' => false,
      'scope' => 'user_events',
    );

    $user = new User(new \Facebook($config));

    $this->view->setVar("user_profile", $user->getUser());
    $this->view->setVar("login_url", $user->getLoginUrl());
    $this->view->setVar("events", $user->getEvents());
    $this->view->setVar("has_permission", $user->hasPermission('user_events'));
    $this->view->pick("index/index");


  }

}