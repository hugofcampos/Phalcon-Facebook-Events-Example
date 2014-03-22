<?php

namespace FBEvents\Libraries\Facebook;

use Phalcon\DI\Injectable;

class User extends Injectable
{  

  private $user_id;

  private $facebook;

  private $user_profile;

  private $login_url;

  private $permissions;

  public function __construct( \Facebook $facebook ){
    $this->facebook = $facebook;
    $this->user_id = $this->facebook->getUser();
    $this->login_url = $this->facebook->getLoginUrl(array('scope' => 'user_events'));
    $this->permissions = $this->getPermissions();    
  }  

  public function getUser(){
    if($this->user_profile) return $this->user_profile;
    
    if($this->user_id){
      try {
        $user_profile = $this->facebook->api('/me','GET');
        $this->user_profile = $user_profile;
        return $this->user_profile;
      
      } catch(FacebookApiException $e) {
        $login_url = $this->facebook->getLoginUrl();
        error_log($e->getType());
        error_log($e->getMessage());
      }
    }

    return false;
  }

  public function getLoginUrl(){
    return $this->login_url;
  }

  public function getEvents(){    
    if($this->user_id && $this->hasPermission('user_events')){
      try {
        $events = $this->facebook->api('/me/events', 'GET');
        return $events;
      
      } catch(FacebookApiException $e) {
        error_log($e->getType());
        error_log($e->getMessage());
      }
    }

    return false;
  }

  public function getPermissions(){
    if($this->permissions) return $this->permissions;

    if($this->user_id){  
      try {
        $permissions = $this->facebook->api('/me/permissions', 'GET');
        return $permissions;
      
      } catch(FacebookApiException $e) {
        error_log($e->getType());
        error_log($e->getMessage());
      }
    }

    return array();
  }

  public function hasPermission($permission){
    return array_key_exists($permission, $this->permissions['data'][0]);
  }

}
