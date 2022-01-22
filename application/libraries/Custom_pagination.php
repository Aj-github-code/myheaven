<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Custom_pagination
{
	function __construct()
	{
		$this->ci =& get_instance();
	}

	function get_pagination_config($settings)
	{
	       $config 					= [];
               $config['base_url']         = $settings['base_url'];
                $config['use_page_numbers'] = TRUE;
                $config['total_rows']       = $settings['total_rows'];
                $config['per_page']         = $settings['limit'];

                $config['full_tag_open']    = '<nav class="toolbox toolbox-pagination"><ul class="pagination">';
                $config['full_tag_close']   = '</ul></nav>';
                $config['num_tag_open']     = '<li class="page-item">';
                $config['num_tag_close']    = '</li>';
                $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
                $config['cur_tag_close']    = '</span></li>';
                $config['next_tag_open']    = '<li class="page-item next">';
                $config['next_tag_close']   = '</li>';
                $config['prev_tag_open']    = '<li class="page-item previous">';
                $config['prev_tag_close']   = '</li>';
                $config['first_tag_open']   = '<li class="page-item">';
                $config['first_tag_close']  = '</li>';
                $config['last_tag_open']    = '<li class="page-item">';
                $config['last_tag_close']   = '</li>';
                return $config;
	}
}