<?php
class Blog_model extends CI_Model {
 
    function __construct()
    {
        parent::__construct();
    }
    
    public function getArticles() {
      return array(
        array('title' => 'Hello word', 'content' => 'Hello word content')
        , array('title' => 'Test news', 'content' => 'Test news content')
      );
    }
    
    public function getAdminByModel() {
      $this->load->model('admin/admin_model');
      return $this->admin_model->getAdmin();
    }
}