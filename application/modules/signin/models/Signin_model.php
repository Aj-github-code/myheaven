<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Signin_model extends CI_Model
    {
        private $table_users                = signin_table::sql_tbl_users;
        private $table_user_ip_blacklist    = signin_table::sql_tbl_user_ip_blacklist;
        private $table_pinreferencetable    = signin_table::sql_tbl_user_pinreferencetable;
        private $table_pintable             = signin_table::sql_tbl_user_pintable;

        public function __construct()
        {
            parent::__construct();
            $this->search = '';
        }

        function get_user_data($type, $paramvalue) {
            if($type == 'email')
            {
                $this->db->where('email', $paramvalue);
            }
            else
            {
                $this->db->where('mobile', $paramvalue);
            }
            $this->db->where('status !=', '-1');
            $query=$this->db->get($this->table_users);
            $row = $query->row_array();
            if(!empty($row))
            {
                return $row;
            }
            else
            {
                return [];
            }
        }

        function update_user_table($id, $data) {
            $this->db->where('id', $id);
            $this->db->update($this->table_users, $data);
        }

        function check_user_ip_blacklist($column, $value) {
            $this->db->where($column, $value);
            $query      = $this->db->get($this->table_user_ip_blacklist);
            $num_rows   = $query->num_rows();
            return $num_rows;
        }

        function get_ip_blacklist($col, $value) {
            $this->db->where($col, $value);
            $query = $this->db->get($this->table_user_ip_blacklist);
            return $query;
        }

        function update_user_ip_blacklist($id, $data) {
            $this->db->where('id', $id);
            $this->db->update($this->table_user_ip_blacklist, $data);
        }
        function updateSponsor($columnName, $randNumber,$placementid) {  

            //$query = 'UPDATE ' . USER_OPTION_TABLE . ' SET ' .$columnName.'="' . $randNumber . '" WHERE ownid="' . $placementid . '"';
            $this->db->where('ownid', $placementid);
            $this->db->update($this->table_users,[$columnName=>$randNumber]);
        }


        function insert_user_ip_blacklist($data) {
            $this->db->insert($this->table_user_ip_blacklist, $data);
        }


        function insertIntoPinReferenceTable($randNumber){
        //$query_re1 = "INSERT INTO pinreferencetable_re (ownid) VALUES('".trim($randNumber)."')";
         //$query_re = "INSERT INTO pinreferencetable1p (ownid) VALUES('".trim($randNumber)."')";
         // $query = "INSERT INTO " .PINREFERENCE_TABLE." (ownid) VALUES('".trim($randNumber)."')";
            $this->db->insert($this->table_pinreferencetable,["ownid"=>$randNumber]);

        }



     function updateUnits($ownid,$pinno){
    $objhelperClass=new helperClass();
    
    // $query = "select * from useroption where `ownid`='".$ownid."'";
    //     $res = mysql_query($query);
    //     $row = mysql_fetch_array($res);
     $this->db->select('placementid,placement,sponsorid');
                $this->db->where('ownid !=',$userid);
                $query=$this->db->get($this->table_users);
                $row = $query->row_array();


    $join_amt='1';
    
        /* if($row['sponsorid']!=''){ */
    
     if($row['placementid']!=''){
            if($row['placement'] =='leftmember')
            {       
                $columname = 'totalunitleft';  
                $column='totalleft';
            }
            else
            {
                $columname = 'totalunitright'; 
                $column='totalright';       
            }
      //$pinno=$post['pinno'];
      $pv=$this->pv($pinno);
      $amt=$pv;
        if(empty($amt) or $amt=='' or $amt==null){
         $amt=0;
       }
     $amt=0;
      
    
        $updateUnitsQuery = "UPDATE ".PINREFERENCE_TABLE." SET `".$columname."`=$columname + $amt,`".$column."`=$column +$join_amt WHERE ownid='".$row['placementid']."'";
       mysql_query($updateUnitsQuery);
$timestamp=date('Y-m-d');
updateUnits($row['placementid'],$pinno);
 
        }
    }



        function pv($pin)
        {

            // $q1="select value from pintable where pinno='$pin'";
            // $row1=mysql_fetch_array(mysql_query($q1));

            $this->db->select('value');
            $query = $this->db->get($this->table_pintable);

            if ($query->num_rows() > 0) {
                $row1= $query->result();

            } else {
                return [];
            }
            $type=$row1['value'];
            return $type;
        }


        function delete_user_ip_blacklist($column, $value) {
            $this->db->where($column, $value);
            $this->db->delete($this->table_user_ip_blacklist);
        }
        function isUserExist($ownid) {
            $this->db->select('id');
            $this->db->where('ownid', $ownid);
            $query = $this->db->get($this->table_users);
            //echo $this->db->last_query();
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
        function userCount() {
            $this->db->select_max('id');
            $query = $this->db->get($this->table_users);

            if ($query->num_rows() > 0) {
                return $query->row_array();
            } else {
                return [];
            }
        }
       
         function getPlacement($userid,$columnName)
            {
            
                $this->db->select($columnName);
                $this->db->where('ownid =',$userid);
                $query=$this->db->get($this->table_users);
                $row = $query->row_array();
                // $query = "SELECT ".$columnName." FROM " . $this->table_users . " WHERE ownid='".$userid."'";
                // $res = mysql_query($query);
                // $row = mysql_fetch_array($res);        
                if($row[$columnName] != '')
                {
                return $this->getPlacement($row[$columnName],$columnName);
                }
                else
                {
                return $userid;
                }        
            }
    }