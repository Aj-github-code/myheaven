<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Commonmodel extends CI_Model
    {
        private $table_users                    = Signin_table::sql_tbl_users;

        public function __construct()
        {
            parent::__construct();
        }
    }