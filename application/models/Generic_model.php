<?php

class Generic_model extends CI_Model{
    
 
//    GENERIC Model for Insert data
    
 public function insertData($tblName, $dataset){
    $this->db->insert($tblName, $dataset);
    $rst =$this->db->insert_id();
    return $rst;
 }
 
 //    GENERIC Model for Update data
 function updateData($tablename, $data_arr, $where_arr) {
        try {
            $this->db->update($tablename, $data_arr, $where_arr);
            $report = array();
            $report['error'] = $this->db->error();
            //$report['message'] = $this->db->_error_message();
            return $report;
        } catch (Exception $err) {

            return $err->getMessage();
        }
    }
    
    
 
//    GENERIC Model for auto complete
    
 public function ifExist($table,$check){
     
    $result=$this->db->get_where($table, array('sup_prefix'=>$check))->result();
    
    if(empty($result)){
        echo "FALSE";
    }
    else{
        echo "TRUE";
    }
    
 }
 
 
 //    GENERIC Model for Select Data
 
 function getData($tablename = '', $columns_arr = array(), $where_arr = array(), $limit = 0, $offset = 0, $orderby = array()) {
        $limit = ($limit == 0) ? Null : $limit;

        if (!empty($columns_arr)) {
            $this->db->select(implode(',', $columns_arr), FALSE);
        }

        if ($tablename == '') {
            return array();
        } else {
            $this->db->from($tablename);

            if (!empty($where_arr)) {
                $this->db->where($where_arr);
            }

            if ($limit > 0 AND $offset > 0) {
                $this->db->limit($limit, $offset);
            } elseif ($limit > 0 AND $offset == 0) {
                $this->db->limit($limit);
            }

            if (count($orderby) > 0) {
                $orderbyString = '';

                foreach ($orderby as $orderclause) {

                    $orderbyString .= $orderclause["field"] . ' ' . $orderclause["order"] . ', ';
                }
                if (strlen($orderbyString) > 2) {
                    $orderbyString = substr($orderbyString, 0, strlen($orderbyString) - 2);
                }
                $this->db->order_by($orderbyString);
            }

            $query = $this->db->get();

            
            return $query->result();
             
        }
    }
 
//    GENERIC Model for Get Count
    
    function getCount($tablename = '', $where_arr = array()) {
        
        if ($tablename == '') {
            return array();
        } else {
            $this->db->from($tablename);

            if (!empty($where_arr)) {
                $this->db->where($where_arr);
            }

        $query = $this->db->get();
        $rowcount = $query->num_rows();

        return $rowcount;
        }
    }
    
    
//    GENERIC Model for Get maximum ID  (Last Inserted ID)
    
    function getmax($tablename = '', $column = '') {
            
            $this->db->select_max($column);
            $this->db->from($tablename);

            
            $query = $this->db->get();
            $result=$query->result();
            $max=$result[0]->$column;
            
            return $max;
        
    }
    
    
//    GENERIC Model for auto complete
    
    function getAutoComplete($tablename = '', $columns_arr = array(), $like_arr = array(), $limit = 0, $offset = 0, $orderby = array()) {
            
            if (!empty($columns_arr)) {
            $this->db->select(implode(',', $columns_arr), FALSE);
        }
        
        if ($tablename == '') {
            return array();
        } else {
            $this->db->from($tablename);

            if (!empty($like_arr)) {
                $this->db->like($like_arr[0],$like_arr[1],$like_arr[2]);
            }
            
            if ($limit > 0 AND $offset > 0) {
                $this->db->limit($limit, $offset);
            } elseif ($limit > 0 AND $offset == 0) {
                $this->db->limit($limit);
            }

            $query = $this->db->get();

            
            return $query->result();
             
        }
        
    }
 
    
//    GENERIC Model for join
    
    public function join($join_tables, $columns_arr = array(), $where_arr = array()){
    
        
        
        $this->db->select('*');    
        $this->db->from($join_tables[0][0]);
        $this->db->join($join_tables[1][0], $join_tables[1][1] );
        
        if (!empty($where_arr)) {
             $this->db->where($where_arr);
            }
        
        $query = $this->db->get();
        
        return $query->result();
       
    }
 
    
     function genQuery($strSQL) {
        if (!empty($strSQL)) {
            try {
                $query = $this->db->query($strSQL);
                if (!$query) {
                    throw new Exception($this->db->_error_message(), $this->db->_error_number());
                    return FALSE;
                } else {
                    return $query->result();
                }
            } catch (Exception $e) {
                return;
            }
        } else {
            return FALSE;
        }
    }
    
    function deleteData($tablename,$where_arr) {
        try {
            $this->db->delete($tablename, $where_arr); 
            $report = array();
            $report['error'] = $this->db->error();
            //$report['message'] = $this->db->_error_message();
            return $report;
        } catch (Exception $err) {

            return $err->getMessage();
        }
    }
    
    
}

?>