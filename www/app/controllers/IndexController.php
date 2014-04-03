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
    $fbevents = $user->getEvents();

    foreach($fbevents['data'] as $e){
      $event = \Events::findFirst(array(
        array("fb_id" => $e['id'])
      ));
      if(!$event){
        $event = new \Events();
      }
      $event->fb_id = $e['id'];
      $event->user = $user->getUser()['id'];
      $event->name = $e['name'];
      $event->location = $e['location'];
      $event->start_time = $e['start_time'];
      $event->status = $e['rsvp_status'];

      $event->save();
    }

    $events = \Events::find(array(
      "sort" => array("start_time" => -1),
      "limit" => 100,
    ));

    $this->view->setVar("user_profile", $user->getUser());
    $this->view->setVar("login_url", $user->getLoginUrl());
    $this->view->setVar("events", $events);
    $this->view->setVar("has_permission", $user->hasPermission('user_events'));
    $this->view->pick("index/index");


  }

}