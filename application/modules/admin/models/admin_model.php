<?php
class Admin_model extends CI_Model {
 
    function __construct()
    {
        parent::__construct();
    }
    
    public function getArray() {
      return array(1,2,3,4,5,6);
    }
    
    public function getAdmin() {
      return array('login'=> 'angel', 'fname' => 'Angel', 'lname' => 'Baev');
    }
}