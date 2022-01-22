<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 |--------------------------------------------------------------------------
 |	CONTROLLER SUMMARY AND DATABASE TABLES
 |--------------------------------------------------------------------------
 | 
 |	Templates is used to put together the main structure of the HTML view. It
 |	calls head, header, content and footer in most cases. Other items can been
 |	called and used. Each part can be dynamic but content is loaded through
 |	modules and methods.
 |
 |	Database table structure
 |
 |	No table
 |
 */

class Templates extends MX_Controller
{
	private $meta_module;

	function __construct() {
		parent::__construct();
	}
	
	function default_template($data) {
		$data['browser'] 				= $this->agent->browser();
		$data['browser_class'] 			= strtolower(str_replace(' ', '_', $data['browser']));
		$data['user_id'] 				= isset($this->data['user_id']) ? $this->data['user_id'] : '';
		$data['session_data'] 			= isset($this->data['session_data']) ? $this->data['session_data'] : [];
		$data['user_data'] 				= isset($this->data['user_data']) ? $this->data['user_data'] : [];
		$data['announcements_not_seen'] = isset($this->data['announcements_not_seen']) ? $this->data['announcements_not_seen'] : [];
		$data['news_not_seen_count'] 	= isset($this->data['news_not_seen_count']) ? $this->data['news_not_seen_count'] : 0;
		$data['news_not_seen'] 			= isset($this->data['news_not_seen']) ? $this->data['news_not_seen'] : [];
		$data['messages_not_seen_count']= isset($this->data['messages_not_seen_count']) ? $this->data['messages_not_seen_count'] : 0;
		$data['messages_not_seen'] 		= isset($this->data['messages_not_seen']) ? $this->data['messages_not_seen'] : [];
		$data['class_name']         	= $this->router->fetch_class();
    	$data['method_name']        	= $this->router->fetch_method();
    	
		$this->load->view('templates/default/head', $data);
		if(isset($data['loggedin']) && $data['loggedin'] == 'yes')
		{
			$this->load->view('templates/default/menu', $data);
			$this->load->view('templates/default/header', $data);
			$this->load->view('templates/default/breadcrumb', $data);
		}
		$this->load->view('templates/default/content', $data);

		if(isset($data['loggedin']) && $data['loggedin'] == 'yes')
		{
			// $this->load->view('templates/default/sidebar', $data);
			$this->load->view('templates/default/footer', $data);
		}
		$this->load->view('templates/default/foot', $data);
	}
	
	function error($data) {
		$meta['meta_title'] 		= isset($data['meta_title']) ? $data['meta_title'] : '';
		$meta['meta_description'] 	= isset($data['meta_description']) ? $data['meta_description'] : '';
		$meta['meta_keywords'] 		= isset($data['meta_keyword']) ? $data['meta_keywords'] : '';
		
		$this->load->view('templates/error/error_template_head', $meta);
		$this->load->view('templates/error/error_template_header', $data);
		$this->load->view('templates/error/error_template_content', $data);
		$this->load->view('templates/error/error_template_footer', $data);
	}
}
