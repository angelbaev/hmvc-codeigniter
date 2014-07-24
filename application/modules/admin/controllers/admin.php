<?php
class Admin extends CI_Controller {
//    public $layout_view = 'layout/default';
    public function __construct() {
      parent::__construct();
       $this->load->config('admin/config');
       $this->load->model('admin/admin_model');
      
//      $this->template = $this->config->item('template');
 //     $this->layout_view = $this->config->item('layout_view');
    }
    
    public function index() {
      $this->load->library('layout', array('template' => $this->config->item('template'), 'layout_view' => $this->config->item('layout_view')));
      
      //  $this->load->controller('blogs/preview', array('specials'));
//      $this->lang->load('admin','english');
//      $this->lang->load('admin/admin');
//      print "fn: ".$this->lang->line('first_name')."<br>";

        

        $data['admin_page_nav'] = $this->config->item('admin_page_nav');
        $this->load->language('admin/admin', 'english');

        $data['first_name'] = $this->lang->line('first_name');
        $data['arr'] = $this->admin_model->getArray();
        $data['preview'] = '';


 /*       
        $this->load->helper('url');
        echo base_url();
$this->load->helper('form');
$attributes = array('class' => 'email', 'id' => 'myform');

echo form_open('email/send', $attributes);

echo form_close();


$this->load->library('email');

// print "<pre>"; print_r($this); print "</pre>";
$this->email->from('your@example.com', 'Your Name');
$this->email->to('someone@example.com');
$this->email->cc('another@another-example.com');
$this->email->bcc('them@their-example.com');

$this->email->subject('Email Test');
$this->email->message('Testing the email class.');

$this->email->send();

echo $this->email->print_debugger();
 */

      //  $data['preview'] = $this->load->controller('blog/preview', array('specials'));

         $this->layout->setTitle('Admin page');
//         $this->layout->view('admin/admin', $data);
         $this->layout->view('admin/admin', $data);


//        $this->load->view('admin/admin', $data);
 //       $this->load->library('layout');
        /*
        PRINT "<pre>"; print_r($this); 
        print "</pre>";
        */
        /*
        $layout = new CI_Layout( array('template' => $this->template));
        $layout->setTitle('Admin page');
        $layout->view($this->layout_view.'index', $data);
        */
//        $this->layout->setTitle('Admin page');
        
//        print_r($test);
      //  $this->layout->setTitle('Admin page');

/*
        $this->load->library('Layout');
        $this->layout->setTtitle('Admin page');
         $this->layout->view('admin/admin', $data);
         */
        
    }
    
    public function test() {
      $this->load->library('layout', array('template' => $this->config->item('template'), 'layout_view' => $this->config->item('layout_view')));
      
      $data['admin_page_nav'] = $this->config->item('admin_page_nav');
      $this->load->language('admin/admin', 'english');

      $data['first_name'] = $this->lang->line('first_name');
      $data['arr'] = $this->admin_model->getArray();
      $data['preview'] = '';
      $this->layout->setTitle('Admin page');
      $this->layout->addScript('http://localhost:82/js/jquery/jquery-2.0.2.js');
      $this->layout->view('admin/admin', $data);
    }

}
