<?php

class IndexController extends \Phalcon\Mvc\Controller
{
  public function indexAction()
  {
    $config = array(
      'appId' => $this->config->facebookapp->appId,
      'secret' => $this->config->facebookapp->secret,
      'allowSignedRequest' => false
    );

    $user_profile = false;
    $login_url = '';

    $facebook = new Facebook($config);
    $user_id = $facebook->getUser();

    if($user_id){
      try {
        $user_profile = $facebook->api('/me','GET');
      } catch(FacebookApiException $e) {
        
        $login_url = $facebook->getLoginUrl();
        error_log($e->getType());
        error_log($e->getMessage());
      }
    } else {        
      $login_url = $facebook->getLoginUrl();        
    }

    $this->view->setVar("user_id", $user_id);
    $this->view->setVar("user_profile", $user_profile);
    $this->view->setVar("login_url", $login_url);

  }

}