<?php 
if(!defined('BASEPATH'))exit('No direct script access allowed');

class Otp_model extends CI_Model{
    private $table_otp  = Otp_table::sql_tbl_otp;

    function __construct() {
        parent::__construct();
        $this->search   = '';
    }

    function inactivateOtp($conditions, $update)
    {
        foreach ($conditions as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->update($this->table_otp, $update);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    function saveOtp($otp_data)
    {
        $this->db->insert($this->table_otp, $otp_data);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    function get_otp_data($conditions=[]) {
        $this->db->select('*');
        $this->db->from($this->table_otp);
        foreach ($conditions as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row_array();
    }
}