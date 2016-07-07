<?php
//require_once('facebook.php');
include(APPPATH.'libraries/redes/facebook/facebook.php');
class Facebook_lib extends Facebook{

   public $user = null;
   public $user_id = null;
   public $fb = false;
   public $fbSession = false;
   public $appKey = 0;
   public function Facebook_lib(){
      $ci =& get_instance();
      $ci->config->load('facebook', TRUE);
      $config = $ci->config->item('facebook');
      parent::__construct($config);

      $this->user_id = $this->getUser();
      $me = null;
      if($this->user_id){
         try{
            $me = $this->api('/me?fields=id,email,first_name,last_name,gender');
            $this->user = $me;
         }catch(FacebookApiException $e){
            error_log($e);
         }
      }

   }


}
?>