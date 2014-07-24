<?php
class Blog extends CI_Controller {
    
    public function __construct() {
      parent::__construct();
      $this->load->model('blog/blog_model');
    }
    
    public function index() {
      $this->load->config('blog/config');
      $data['admin_page_nav'] = $this->config->item('admin_page_nav');
      $this->load->language('blog/blog', 'english');
      $data['arr'] = $this->blog_model->getArticles();
      $data['admin'] = $this->blog_model->getAdminByModel();
      
      $this->load->view('blog/blog', $data);
    }
    
    public function preview() {
      $data = array();
      return $this->load->view('blog/preview', $data, true);
    }
}
