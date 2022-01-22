<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller 
{
	public $autoload = array();
	
	public function __construct() 
	{
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);

		$this->data 						= [
						                        'meta_title' 				=> '',
						                        'meta_keywords' 			=> '',
						                        'meta_description' 			=> '',
						                        'user_id'  					=> $this->session->userdata('user_id'),
						                        'session_data'  			=> $this->session->userdata(),
						                        'user_data'  				=> $this->get_user_details(),
						                        'announcements_not_seen'  	=> $this->get_announcements_not_seen_count(),
						                        'news_not_seen_count'  		=> $this->get_news_not_seen_count(),
						                        'news_not_seen'  			=> $this->get_news_not_seen(),
						                        'messages_not_seen_count'  	=> $this->get_messages_not_seen_count(),
						                        'messages_not_seen'  		=> $this->get_messages_not_seen(),
						                    ];
	}
	
	public function __get($class) 
	{
		return CI::$APP->$class;
	}

	private function get_user_details()
	{
		if(!empty($this->session->userdata('user_id')))
		{
			$where = '(id = "'.$this->session->userdata('user_id').'") AND (status != "-1")';
            $this->db->where($where);
            $query = $this->db->get(signin_table::sql_tbl_users);

            if($query->num_rows() > 0)
            {
            	$userdata = $query->row_array();
            	unset($userdata['password']);
                return $userdata;
            }
            else
            {
                return [];
            }
		}
		else
		{
			return [];
		}
	}

	private function get_announcements_not_seen_count()
	{
		if(!empty($this->session->userdata('user_id')))
		{
			$announcements 		= $this->db->where(['status' => 1])->from(announcements_table::sql_tbl_announcements)->count_all_results();
			$announcements_seen = $this->db->where(['user_id' => $this->session->userdata('user_id')])->from(announcements_table::sql_tbl_announcements_seen)->count_all_results();
			return $announcements - $announcements_seen;
		}
		else
		{
			return 0;
		}
	}

	private function get_news_not_seen_count()
	{
		if(!empty($this->session->userdata('user_id')))
		{
			$news 		= $this->db->where(['type' => 'all', 'status' => 1])->from(news_table::sql_tbl_news)->count_all_results();
			// $news_seen 	= $this->db->where(['type' => 'all', 'user_id' => $this->session->userdata('user_id')])->from(news_table::sql_tbl_news_seen)->count_all_results();

			$this->db->select('count(ns.id) as seen');
            $this->db->from(news_table::sql_tbl_news_seen.' ns');
            $this->db->join(news_table::sql_tbl_news.' n', 'ns.news_id=n.id', 'INNER');
            $this->db->where('ns.type', 'all');
            $this->db->where('ns.user_id', $this->session->userdata('user_id'));
            $this->db->where('n.status', 1);
            $query 		= $this->db->get();
            $news_seen 	= $query->row_array();
            $news_seen 	= (!empty($news_seen['seen']) ? $news_seen['seen'] : 0);

			return $news - $news_seen;
		}
		else
		{
			return 0;
		}
	}

	private function get_messages_not_seen_count()
	{
		if(!empty($this->session->userdata('user_id')))
		{
			$news 		= $this->db->where(['type' => 'franchise', 'status' => 1, 'user_id' => $this->session->userdata('user_id')])->from(news_table::sql_tbl_news)->count_all_results();
			// $news_seen 	= $this->db->where(['type' => 'franchise', 'user_id' => $this->session->userdata('user_id')])->from(news_table::sql_tbl_news_seen)->count_all_results();

			$this->db->select('count(ns.id) as seen');
            $this->db->from(news_table::sql_tbl_news_seen.' ns');
            $this->db->join(news_table::sql_tbl_news.' n', 'ns.news_id=n.id', 'INNER');
            $this->db->where('ns.type', 'franchise');
            $this->db->where('ns.user_id', $this->session->userdata('user_id'));
            $this->db->where('n.user_id', $this->session->userdata('user_id'));
            $this->db->where('n.status', 1);
            $query 		= $this->db->get();
            $news_seen 	= $query->row_array();
            $news_seen 	= (!empty($news_seen['seen']) ? $news_seen['seen'] : 0);

			return $news - $news_seen;
		}
		else
		{
			return 0;
		}
	}

	private function get_news_not_seen()
	{
		if(!empty($this->session->userdata('user_id')))
		{
			$this->db->select('n.id, n.user_id, n.type, n.description');
            $this->db->from(news_table::sql_tbl_news.' n');
            $this->db->where('n.type', 'all');
            $this->db->where('n.status', 1);
            $this->db->where('n.id NOT IN (SELECT ns.news_id from '.news_table::sql_tbl_news_seen.' ns WHERE ns.type="all" AND ns.user_id='.$this->session->userdata('user_id').')', NULL, FALSE);
            $this->db->order_by('n.id', 'DESC');
            $this->db->limit(5);
            $query = $this->db->get();
            return $query->result_array();
		}
		else
		{
			return [];
		}
	}

	private function get_messages_not_seen()
	{
		if(!empty($this->session->userdata('user_id')))
		{
			$this->db->select('n.id, n.user_id, n.type, n.description');
            $this->db->from(news_table::sql_tbl_news.' n');
            $this->db->where('n.type', 'franchise');
            $this->db->where('n.user_id', $this->session->userdata('user_id'));
            $this->db->where('n.status', 1);
            $this->db->where('n.id NOT IN (SELECT ns.news_id from '.news_table::sql_tbl_news_seen.' ns WHERE ns.type="franchise" AND ns.user_id='.$this->session->userdata('user_id').')', NULL, FALSE);
            $this->db->order_by('n.id', 'DESC');
            $this->db->limit(5);
            $query = $this->db->get();
            return $query->result_array();
		}
		else
		{
			return [];
		}
	}
}