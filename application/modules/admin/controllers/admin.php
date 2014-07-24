<?php
class Admin extends CI_Controller {
    public $template = '';
    public $layout_view = '';
//    public $layout_view = 'layout/default';
    public function __construct() {
      parent::__construct();
       $this->load->config('admin/config');
       $this->load->model('admin/admin_model');
      
      $this->template = $this->config->item('template');
      $this->layout_view = $this->config->item('layout_view').'default/';
    }
    
    public function index() {
      //  $this->load->controller('blogs/preview', array('specials'));
//      $this->lang->load('admin','english');
//      $this->lang->load('admin/admin');
//      print "fn: ".$this->lang->line('first_name')."<br>";

        

        $data['admin_page_nav'] = $this->config->item('admin_page_nav');
        $this->load->language('admin/admin', 'english');

        $data['first_name'] = $this->lang->line('first_name');
        $data['arr'] = $this->admin_model->getArray();
        $data['preview'] = $this->load->controller('blog/preview', array('specials'));
//        $this->load->view('admin/admin', $data);
        $this->load->library('layout', array('template' => $this->template));
        $layout = new CI_Layout( array('template' => $this->template));
        $layout->setTitle('Admin page');
        $layout->view($this->layout_view.'index', $data);
//        $this->layout->setTitle('Admin page');
        
//        print_r($test);
      //  $this->layout->setTitle('Admin page');

/*
        $this->load->library('Layout');
        $this->layout->setTtitle('Admin page');
         $this->layout->view('admin/admin', $data);
         */
        
    }

}
