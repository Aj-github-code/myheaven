<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Common_model extends CI_Model
    {
        private $database;
        private $table;

        function __construct() {
            parent::__construct();
            $this->database = $this->db;
        }

        // Unique to models with multiple tables
        function set_table($table) {
            $this->table = $table;
        }
        
        // Get table from table property
        function get_table() {
            $table = $this->table;
            return $table;
        }

        // Retrieve all data from database and order by column return query
        function get($order_by) {
            $db = $this->database;
            $table = $this->get_table();
            $db->order_by($order_by);
            $query=$db->get($table);
            return $query;
        }

        // Limit results, then offset and order by column return query
        function get_with_limit($limit, $offset, $order_by) {
            $db = $this->database;
            $table = $this->get_table();
            $db->limit($limit, $offset);
            $db->order_by($order_by);
            $query=$db->get($table);
            return $query;
        }

        // Get where column id is ... return query
        function get_where($id) {
            $db = $this->database;
            $table = $this->get_table();
            $db->where('id', $id);
            $query=$db->get($table);
            return $query;
        }

        // Get where custom column is .... return query
        function get_where_custom($col, $value) {
            $db = $this->database;
            $table = $this->get_table();
            $db->where($col, $value);
            $query=$db->get($table);
            return $query;
        }

        // Get or where custom column is .... return query
        function get_or_where_custom($col1, $col2, $value) {
            $db = $this->database;
            $table = $this->get_table();
            $db->where($col1, $value);
            $db->or_where($col2, $value);
            $query=$db->get($table);
            return $query;
        }
        
        // Get where with multiple where conditions $data contains conditions as associative
        // array column=>condition
        function get_multiple_where($data) {
            $db = $this->database;
            $table = $this->get_table();
            $db->where($data);
            $query=$db->get($table);
            return $query;
        }
        
        // Get where column like %match% for single where condition
        function get_where_like($column, $match) {
            $db = $this->database;
            $table = $this->get_table();
            $db->like($column, $match);
            $query=$db->get($table);
            return $query;
        }
        
        // Get where column like %match% for each $data. $data is associative array column=>match
        function get_where_like_multiple($data) {
            $db = $this->database;
            $table = $this->get_table();
            $db->like($data);
            $query=$db->get($table);
            return $query;
        }
        
        // Get where column not like %match% for single where condition
        function get_where_not_like($column, $match) {
            $db = $this->database;
            $table = $this->get_table();
            $db->not_like($column, $match);
            $query=$db->get($table);
            return $query;
        }

        // Insert data into table $data is an associative array column=>value
        function _insert($data) {
            $db = $this->database;
            $table = $this->get_table();
            $db->insert($table, $data);
        }
        
        // Insert data into table $data is an associative array column=>value
        function insert_batch($data) {
            $db = $this->database;
            $table = $this->get_table();
            $db->insert_batch($table, $data);
        }

        // Update existing row where id = $id and data is an associative array column=>value
        function _update($id, $data) {
            $db = $this->database;
            $table = $this->get_table();
            $db->where('id', $id);
            $db->update($table, $data);
        }

        // Delete a row where id = $id
        function _delete($id) {
            $db = $this->database;
            $table = $this->get_table();
            $db->where('id', $id);
            $db->delete($table);
        }

        // Delete a row where $column = $value
        function delete_where($column, $value) {
            $db = $this->database;
            $table = $this->get_table();
            $db->where($column, $value);
            $db->delete($table);
        }
        
        // Count results where column = value and return integer
        function count_where($column, $value) {
            $db = $this->database;
            $table = $this->get_table();
            $db->where($column, $value);
            $query=$db->get($table);
            $num_rows = $query->num_rows();
            return $num_rows;
        }

        // Count results multiple where column = value and return integer
        function count_multiple_where($data) {
            $db = $this->database;
            $table = $this->get_table();
            $db->where($data);
            $query=$db->get($table);
            $num_rows = $query->num_rows();
            return $num_rows;
        }

        // Count results or where column = value and return integer
        function count_or_where($column1, $column2, $value) {
            $db = $this->database;
            $table = $this->get_table();
            $db->where($column1, $value);
            $db->or_where($column2, $value);
            $query=$db->get($table);
            $num_rows = $query->num_rows();
            return $num_rows;
        }

        // Count all the rows in a table and return integer
        function count_all() {
            $db = $this->database;
            $table = $this->get_table();
            $query=$db->get($table);
            $num_rows = $query->num_rows();
            return $num_rows;
        }

        // Find the highest value in id then return id
        function get_max() {
            $db = $this->database;
            $table = $this->get_table();
            $db->select_max('id');
            $query = $db->get($table);
            $row=$query->row();
            $id=$row->id;
            return $id;
        }

        // Specify a custom query then return query
        function _custom_query($mysql_query) {
            $db = $this->database;
            $query = $db->query($mysql_query);
            return $query;
        }

        function get_db_connection($db_connection)
        {
            $db_config['dsn']          = '';
            $db_config['hostname']     = $db_connection['hostname'];
            $db_config['username']     = $db_connection['username'];
            $db_config['password']     = $db_connection['password'];
            $db_config['database']     = $db_connection['database'];
            $db_config['dbdriver']     = "mysqli";
            $db_config['dbprefix']     = $db_connection['dbprefix'];
            $db_config['pconnect']     = FALSE;
            $db_config['db_debug']     = FALSE;
            $db_config['cache_on']     = FALSE;
            $db_config['cachedir']     = "";
            $db_config['char_set']     = "utf8";
            $db_config['dbcollat']     = "utf8_general_ci";
            $db_config['swap_pre']     = "";
            $db_config['encrypt']      = FALSE;
            $db_config['compress']     = FALSE;
            $db_config['stricton']     = FALSE;
            $db_config['failover']     = array();
            $db_config['save_queries'] = TRUE;

            $conn = $this->load->database($db_config, true);
            if(isset($conn->conn_id) && !empty($conn->conn_id))
            {
                return ['error' => 0, 'temp_db_obj' => $conn];
            }
            else
            {
                return ['error' => 1, 'message' => 'Unable to connect to database'];
            }
        }
    }