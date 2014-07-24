<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		Angel Baev
 * @copyright	Copyright (c) 2011 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Layout Class
 *
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Angel Baev
 * @link		
 */
class CI_Layout {
    private $CI;
    private $layout_view;
    private $template;
    private $title = '';
    private $meta_tag_list = array();
    private $css_list = array();
    private $javascript_list = array();
    private $style_declaration = '';
    private $javascript_declaration = '';
    private $block_list;
    private $block_new; 
    private $block_replace = FALSE;
    
	/**
	 * Constructor - Sets Layout Preferences
	 *
	 * The constructor can be passed an array of config values
	 */
	public function __construct($config = array()) {
		if (count($config) > 0)
		{
			$this->initialize($config);
		}

//    $this->CI = & get_instance();
 //   $this->layout_view = 'layout/default.php';  // ???
    
//    if (isset($this->CI->layout_view)) $this->layout_view = $this->CI->layout_view;
 //   if (isset($this->CI->template)) $this->template = $this->CI->template;
    
		log_message('debug', "Layout Class Initialized");
  
  } //__construct()

	/**
	 * Initialize preferences
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */
   public function initialize($config = array()) {

        $defaults = array(
            'layout_view' => '',
            'template' => '',
            'title' => '',
            'meta_tag_list' => array(),
            'css_list' => array(),
            'javascript_list' => array(),
            'style_declaration' => '',
            'javascript_declaration' => '',
            'block_list' => array(),
            'block_new' => '',
            'block_replace' => FALSE
        );


        foreach ($defaults as $key => $val) {
            if (isset($config[$key])) {
                $method = 'set_' . $key;
                if (method_exists($this, $method)) {
                    $this->$method($config[$key]);
                } else {
                    $this->$key = $config[$key];
                }
            } else {
                $this->$key = $val;
            }
        }
    
      return $this;
   }   
  
	/**
	 * Set Meta data
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	bolean
	 * @return	void
	 */
  public function setMetaData($name = '', $content = '', $http_equiv = FALSE) {
     $this->meta_tag_list[$name] = array(
      'NAME' => $name,
      'CONTENT' => $content,
      'HTTP_EQUIV' => $http_equiv
     );

  } //setMetaData()

	/**
	 * Adding JavaScript
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	bolean
	 * @return	void
	 */
   public function addScript($src, $type = 'text/javascript', $charset = 'UTF-8', $async = FALSE) {
      $this->javascript_list[$src] = array(
        'SRC' => $src,
        'TYPE' => $type,
        'CHARSET' => $charset, 
        'ASYNC' => $async
      );
   }

	/**
	 * Adding StyleSheet
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	bolean
	 * @return	void
	 */
   public function addStyleSheet($href, $type = 'text/css', $rel = 'stylesheet', $media = '',  $hreflang = '') {
      $this->css_list[$href] = array(
        'HREF' => $href,
        'TYPE' => $type,
        'REL' => $rel, 
        'MEDIA' => $media,
        'LANG' => $hreflang,
      );
   
   }

	/**
	 * Adding JavaScript  Declaration
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
   public function addScriptDeclaration($script = '') {
      $this->javascript_declaration .= $script; 
   }

	/**
	 * Adding StyleSheet  Declaration
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
   public function addStyleSheetDeclaration($style = '') {
      $this->style_declaration .= $style;
   }
   
	/**
	 * Set page title
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
   public function setTitle($title) {
      $this->title = $title;
   }
   
	/**
	 * Add new block
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
   public function block($name = '') {
      if (!empty($name)) {
          $this->block_new = $name;
          ob_start();
      } else {
          if($this->block_replace) {
            if(!isset($this->block_list[$this->block_new])) {
               ob_end_clean();
               echo $this->block_list[$this->block_new];
            }
          } else {
            $this->block_list[$this->block_new] = ob_get_clean();
          }
      }
   }
   
	/**
	 * Layout view
	 *
	 * @access	public
	 * @param	string
	 * @param	NULL
	 * @param	bolean
	 * @return	void
	 */
   public function view($view, $data = NULL, $return = FALSE) {
   print "TPL: ".$this->template."<br>";
     /*
     Render template
     */
     $data['content_for_layout'] = $this->CI->load->view($view, $data, true);
     $data['title_for_layout'] = $this->title;
     
     /*
      Render resources
     */
     $data['meta_for_layout'] = '';
     foreach($this->meta_tag_list as $meta) {
           if($meta['HTTP_EQUIV']) {
              $data['meta_for_layout'] .= sprintf('<meta http-equiv="%s" content="%s">', $meta['NAME'], $meta['CONTENT']);
           } else {
              $data['meta_for_layout'] .= sprintf('<meta name="%s" content="%s">', $meta['NAME'], $meta['CONTENT']);
           }
     }
     
     $data['javascript_for_layout'] = '';
     foreach($this->javascript_list as $script) {
           if($script['ASYNC']) {
              $data['javascript_for_layout'] .= sprintf('<script src="%s" type="%s" charset="%s" async></script> ', $script['SRC'], $script['TYPE'], $script['CHARSET']);
           } else {
              $data['javascript_for_layout'] .= sprintf('<script src="%s" type="%s" charset="%s"></script> ', $script['SRC'], $script['TYPE'], $script['CHARSET']);
           }
     }
     
     $data['css_for_layout'] = '';
     foreach($this->css_list as $css) {
          if (!empty($css['MEDIA']) && !empty($css['LANG'])) {
            $data['css_for_layout'] .= sprintf('<link rel="%s" type="%s" href="%s" media="print" hreflang="%s"> ', $css['REL'], $css['TYPE'], $css['HREF'], $css['LANG']);
          } else if (!empty($css['MEDIA'])) {
            $data['css_for_layout'] .= sprintf('<link rel="%s" type="%s" href="%s" media="%s">', $css['REL'], $css['TYPE'], $css['HREF'], $css['MEDIA']);
          } else if (!empty($css['LANG'])) {
            $data['css_for_layout'] .= sprintf('<link rel="%s" type="%s" href="%s" hreflang="%s">', $css['REL'], $css['TYPE'], $css['HREF'], $css['LANG']);
          } else {
            $data['css_for_layout'] .= sprintf('<link rel="%s" type="%s" href="%s">', $css['REL'], $css['TYPE'], $css['HREF']);
          }
     }

     $data['javascript_declaration_for_layout'] = '
      <script type="text/javascript">
      '.$this->javascript_declaration.'
      </script>
     ';
     $data['style_declaration_for_layout'] = '
     <style type="text/css">
      '.$this->style_declaration.'
     </style>
     ';

     $this->block_replace = true;
     return $this->CI->load->view($this->layout_view, $data, $return);
     
   }
    
}
// END CI_Layout class

/* End of file Layout.php */
/* Location: ./application/libraries/Layout.php */
