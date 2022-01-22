<?php
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	
	require_once APPPATH."modules/pdf/third_party/tcpdf/tcpdf.php";
	class Pdf extends TCPDF {
		private $ci;

	    public function __construct() {
	        parent::__construct();
	        $this->ci 					= get_instance();
	    }

	    function process($pdf_data)
	    {
	    	$mode 						= $pdf_data['mode'];
	    	$file_name 					= $pdf_data['file_name'];
	    	$html 						= $pdf_data['html'];
	    	$file_path 					= $pdf_data['file_path'];

	    	$this->ci 					= get_instance();
	    	$this->ci->pdf->setPrintHeader(false);
	        $this->ci->pdf->setPrintFooter(false);
	        $this->ci->pdf->SetCellPadding(1.5);
	        $this->ci->pdf->setImageScale(1.42);
	        $this->ci->pdf->AddPage();
	        $this->ci->pdf->SetFontSize(10);

	        if($mode != "html")
	        {
	            $this->ci->pdf->writeHTML($html, true, false, true, false, '');
	        }

	        if($mode === "download")
	        {
	            $this->ci->pdf->Output($file_name, "D");
	        }
	        else if($mode === "send_email")
	        {
	            $temp_download_path 	= $this->directory($file_path);
	            $temp_download_path 	= $temp_download_path['absolute_path'].$file_name;
	            $this->ci->pdf->Output($temp_download_path, "F");
	            return $temp_download_path;
	        }
	        else if($mode === "view")
	        {
            	$this->ci->pdf->Output($file_name, "I");
	        }
	        else if($mode === "html")
	        {
	            return $html;
	        }
	    }

	    function directory($path=[])
	    {
	    	$directory 					= ['absolute_path' => '', 'relative_path' => ''];
	        if(!empty($path))
	        {
	            $absolute_path          = getcwd().'/'.$this->ci->config->item('content_path');
	            $relative_path          = '';
	            foreach ($path as $key => $value) 
	            {
	                $absolute_path      = $absolute_path.$value.'/';
	                $relative_path      = $relative_path.$value.'/';
	                if (!is_dir($absolute_path)) 
	                {
	                    mkdir($absolute_path, 0777, true);
	                }
	            }
	            $directory 				= ['absolute_path' => $absolute_path, 'relative_path' => $relative_path];
	        }
	        return $directory;
	    }
	}