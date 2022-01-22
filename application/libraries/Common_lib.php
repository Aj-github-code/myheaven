<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_lib
{
	function __construct()
	{
		$this->ci =& get_instance();
	}

	function get_client_ip() {
	    $ipaddress 	   = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       	$ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

	function get_domain()
	{
	    return preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/","$1", $this->ci->config->slash_item('base_url'));
	}

	function generatePassword()
    {
        $characters       = '$2y$10$rTm6OxA6pvpURjoR9PRdA.fOx5JcK0UsuRNJmaVGCxUj9aDcy.qVy123';
        $charactersLength = strlen($characters);
        $randomString     = '';
        $randomString    .= $characters[rand(0, $charactersLength - 1)];
        $randomString    .= $characters[rand(0, 9)];
        $randomString    .= $characters[rand(10, 35)];
        $randomString    .= $characters[rand(36, 61)];
        $randomString    .= $characters[rand(62, $charactersLength - 1)];
        $randomString    .= $characters[rand(10, 35)];
        $randomString    .= $characters[rand(0, $charactersLength - 1)];
        $randomString    .= $characters[rand(0, $charactersLength - 1)];
        // $randomString       = '$2y$10$rTm6OxA6pvpURjoR9PRdA.fOx5JcK0UsuRNJmaVGCxUj9aDcy.qVy';
        return $randomString;
    }

    function generate_random_string($length='')
	{
	    $characters 	= '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	    $length 		= !empty($length) ? $length : strlen($characters);
	    return substr(str_shuffle($characters), 0, $length);
	}

    function get_url_hash_alias()
    {
    	$static_str         = 'NX';
        $currenttimeseconds = date("Ymd_His");
        $string_pt1         = $static_str.$currenttimeseconds;
        $string_pt2         = rand(100000, 999999);
        $token              = sha1($string_pt1.$string_pt2);
        $token              = str_split($token, 4);
        $token              = implode('-', $token);
        return $token;
    }

    function split_number($x, $n)
	{
		$numbers = [];
		if($x < $n)
		{
			$numbers[] = (-1);
		}
		else if($x % $n == 0)
		{
			for($i = 0; $i < $n; $i++)
			{
				$numbers[] = ($x / $n);
			}
		}
		else
		{
			$zp = $n - ($x % $n);
			$pp = $x / $n;
			for ($i = 0; $i < $n; $i++)
			{
				if($i >= $zp)
				{
					$numbers[] = (int)$pp + 1;
				}
				else
				{
					$numbers[] = (int)$pp;
				}
			}
		}
		return $numbers;
	}

	function get_pagination_config($settings)
	{
		$config 					= [];
	    $config['base_url']         = $settings['base_url'];
        $config['use_page_numbers'] = TRUE;
        $config['total_rows']       = $settings['total_rows'];
        $config['per_page']         = $settings['limit'];

        $config['full_tag_open']    = '<ul class="pagination url1-links justify-content-end">';
        $config['full_tag_close']   = '</ul>';
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close']    = '</a></li>';
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

	function percentage($number=0, $out_of_number=0)
	{
		$percent 		= 0;
		if($number > 0 && $out_of_number > 0)
		{
			$percent 	= ($number / $out_of_number) * 100;
		}

		return $percent;
	}

	function maskMobileNumber($number)
	{
	    $mask_number =  str_repeat("*", strlen($number)-4) . substr($number, -4);
	    return $mask_number;
	}

	function maskEmail($email)
	{
	    $em   = explode("@", $email);
	    $name = implode(array_slice($em, 0, count($em)-1), '@');
	    $len  = floor(strlen($name)/2);

	    return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);   
	}

	function isDate($value) 
	{
	    if (!$value) {
	        return false;
	    }

	    try {
	        new \DateTime($value);
	        return true;
	    } catch (\Exception $e) {
	        return $e;
	    }
	}
	function AmountInWords(float $amount)
	{
		$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
		// Check if there is any number after decimal
		$amt_hundred = null;
		$count_length = strlen($num);
		$x = 0;
		$string = array();
		$change_words = array(0 => '', 1 => 'One', 2 => 'Two',
		3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
		7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
		10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
		13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
		16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
		19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
		40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
		70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
		$here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
		while( $x < $count_length ) {
			$get_divider = ($x == 2) ? 10 : 100;
			$amount = floor($num % $get_divider);
			$num = floor($num / $get_divider);
			$x += $get_divider == 10 ? 1 : 2;
			if ($amount) {
				$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
				$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
				$string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
				'.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
				'.$here_digits[$counter].$add_plural.' '.$amt_hundred;
			}
			else $string[] = null;
		}
		$implode_to_Rupees = implode('', array_reverse($string));
		$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
		" . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
		return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
	}
	function generateUniqueColumnCode($table, $column, $prefix='DC', $length=6)
	{
        $code 					= '';
        $bind_prefix 			= '';
        do{
        	if(!empty($prefix))
        	{
        		$bind_prefix 	= $prefix.'-';
        	}
        	$code 				= $bind_prefix.strtoupper($this->generate_random_string($length));
        	$conditions 		= [$column => $code];
        	$count 				= $this->ci->db->where($conditions)->get($table)->num_rows();
        }
        while($count > 0);
        return $code;
	}

	function generateUniqueColumnSerialCode($table, $column, $target_column, $prefix='DC', $length=6, $fill='0')
	{
        $code 					= '';
        $bind_prefix 			= '';
        do{
        	if(!empty($prefix))
        	{
        		$bind_prefix 	= $prefix.'-';
        	}

        	$last_row 			= $this->ci->db->select($column)->order_by($column, 'DESC')->limit(1)->get($table)->row_array();
        	$id 				= isset($last_row[$column]) ? $last_row[$column] : 0;
	        $next               = $id+1;
	        $code               = $bind_prefix.str_pad($next, $length, $fill, STR_PAD_LEFT);

        	$conditions 		= [$target_column => $code];
        	$count 				= $this->ci->db->where($conditions)->get($table)->num_rows();
        }
        while($count > 0);
        return $code;
	}
}