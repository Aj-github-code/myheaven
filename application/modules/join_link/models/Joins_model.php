<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Joins_model extends CI_Model
    {
        private $table_users                = signin_table::sql_tbl_users;
        private $table_user_ip_blacklist    = signin_table::sql_tbl_user_ip_blacklist;

        public function __construct()
        {
            parent::__construct();
        }

       
    }