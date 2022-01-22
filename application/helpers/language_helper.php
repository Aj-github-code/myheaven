<?php
    defined('BASEPATH') or exit ('No direct script access allowed');
    
	function _language_loader()
    {
        $CI =& get_instance();
        $CI->is_rtl = FALSE;
        $CI->language = "";

        if($CI->config->item("language") == "arabic")
        {
            $CI->is_rtl = TRUE;
        }

        if(!$CI->config->item("language") || $CI->config->item("language") == "")
        {
            $CI->language = "english";
        }
        else
        {
            $CI->language = $CI->config->item('language');
        }

        $CI->lang->load('auth', $CI->language);
        $CI->lang->load('common', $CI->language);
    }
