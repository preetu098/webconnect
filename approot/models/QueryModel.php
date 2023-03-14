<?php
class QueryModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function insert($table, $dataArr)
    {
        if ($this->db->insert($table, $dataArr)) {
            //$this->db->last_query();
            return $this->db->insert_id();
        }
    }

    public function update($table, $dataArr, $where)
    {
        $this->db
            ->set($dataArr)
            ->where($where)
            ->update($table);
        //echo $this->db->last_query();
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function delete($table, $where)
    {
        $this->db->where($where);
        return $this->db->delete($table);
        //echo $this->db->last_query();
    }

    function single($table, $column = "*", $where = null)
    {
        $query = $this->db
            ->select($column)
            ->from($table)
            ->where($where)
            ->get();
        if ($column == "*") {
            //echo $this->last->query();
            return $query->row();
        } else if (!empty($column)) {
            return $query->row();
        } else {
            return $query->row()->$column;
        }
        //echo $this->last->query();
    }

    public function all($table, $column = "*",  $where = "1=1", $srcharr = '', $searchType = 'both', $groupBy = '', $orderColumn = '', $orderBy = 'ASC', $limit = NULL, $offset = 0)
    {
        $searchArr = array("'.$srcharr.'" => '');
        $query = $this->db
            ->select($column, FALSE)
            ->from($table)
            ->where($where)
            ->like($searchArr, FALSE, $searchType)
            ->order_by($orderColumn, $orderBy)
            ->group_by($groupBy)
            ->limit($limit, $offset)
            ->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    //    public function countRec($table, $where = null) {
    //        $this->db->where($where);
    //        $count =  $this->db->count_all_results($table);
    //        //echo $this->db->last_query();
    //        return $count;
    //    }
    //    
    //    public function getFoundRows(){
    //        $query = $this->db->query("select FOUND_ROWS() AS total");
    //        $row = $query->row();
    //        //$this->db->last_query();
    //	return $row->total;
    //    }


    /*
     * To join multiple tables
     * $table = "product_category as pcat";
     * $columnArr = array('pcat.category', 'pro.NameProduct', 'pro.IdProduct', 'cat.NameCategory', 'cat.IdCategory', 'pri.ProductPrice');        
       $dataArr = array
         ('product as pro' => 'pcat.IdProduct = pro.IdProduct',
          'category as cat' => 'pcat.IdCategory = cat.IdCategory',
          'price as pri' => 'pcat.IdPrice = pri.IdPrice'
         );
     */

    public function join($table, $columnArr, $dataArr, $joinType = 'INNER', $where = NULL, $searchArr = array(), $searchType = 'both', $groupBy = '', $orderColumn = '', $orderBy = 'ASC', $limit = NULL, $offset = 0, $resultType = null)
    {
        $cnt = 0;
        // print_r($this->session->userdata());
        foreach ($columnArr as $columns) {
            $cnt++;
            /*if($cnt == 1){
                $this->db->select("SQL_CALC_FOUND_ROWS ".$columns, FALSE);
            } else {
                $this->db->select($columns);
            }  */
            $this->db->select($columns);
            //$this->db->select($columns, FALSE);
        }
        $this->db->from($table);
        foreach ($dataArr as $key => $value) {
            $this->db->join($key, $value, $joinType);
        }
        $this->db->where($where);
        //$this->db->like($searchArr, FALSE, $searchType);
        $this->db->order_by($orderColumn, $orderBy);
        $this->db->group_by($groupBy);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($resultType == 'row') {
            return $query->row();
        } else {
            return $query->result();
        }
    }

    public function testme()
    {
        echo "This is testing section";
    }

    public function upload($url, $name, $exe = "'jpg|jpeg|png|jpg|gif'")
    {

        $config['upload_path'] = $url;
        $config['allowed_types'] = $exe;
        $config['file_name'] = $_FILES[$name]['name'];
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload($name)) {
            $uploadData = $this->upload->data();
            return $picture = $uploadData['file_name'];
        } else {
            return $picture = '';
        }
    }

    public function multiupload($url, $name, $exe = "'jpg|jpeg|pdf|jpg|gif'")
    {
        $config['upload_path'] = $url;
        $config['allowed_types'] = $exe;
        $config['file_name'] = $_FILES[$name]['name'];
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload($name)) {
            $uploadData = $this->upload->data();
            return $picture = $uploadData['file_name'];
        } else {
            return $picture = '';
        }
    }

    public function newdb123()
    {
        $db2 = $this->load->database('db2', true);
        $query = $db2->get("ad_policy");
        return $query->result();
    }

    public function all2($table, $column = "*",  $where = "1=1", $srcharr = '', $searchType = 'both', $groupBy = '', $orderColumn = '', $orderBy = 'ASC', $limit = NULL, $offset = 0)
    {
        $db2 = $this->load->database('db2', true);
        $searchArr = array("'.$srcharr.'" => '');
        $query = $db2
            ->select($column, FALSE)
            ->from($table)
            ->where($where)
            ->like($searchArr, FALSE, $searchType)
            ->order_by($orderColumn, $orderBy)
            ->group_by($groupBy)
            ->limit($limit, $offset)
            ->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function single2($table, $column = "*", $where = null)
    {
        $db2 = $this->load->database('db2', true);
        $query = $db2
            ->select($column)
            ->from($table)
            ->where($where)
            ->get();
        if ($column == "*") {
            //echo $this->last->query();
            return $query->row();
        } else if (@count($column) > 1) {
            return $query->row();
        } else {
            return $query->row()->$column;
        }
        //echo $this->last->query();
    }

    public function get_files($policy_id)
    {
        $db2 = $this->load->database('db2', true);
        $db2->select('pf.ad_policy_file_id,f.file_name,pfs.policy_file_name');
        $db2->from('ad_policy_file pf');
        $db2->join('ad_crm_files f', 'f.file_id = pf.file_id', 'left');
        $db2->join('ad_policy_file_setup pfs', 'pfs.policy_file_id = pf.policy_file_id', 'left');
        $db2->where('pf.policy_id', $policy_id);
        $db2->where('pfs.policy_file_name', 'New Policy');
        $q = $db2->get();
        return ($q->num_rows() < 1) ? 0 : $q->row();
    }

    public function get_end_files($endorsement_id)
    {
        $db2 = $this->load->database('db2', true);
        $db2->select('ef.ad_endorsement_file_id,f.file_name,efs.endorsement_file_name');
        $db2->from('ad_endorsement_file ef');
        $db2->join('ad_crm_files f', 'f.file_id = ef.file_id', 'left');
        $db2->join('ad_endorsement_file_setup efs', 'efs.endorsement_file_id = ef.endorsement_file_id', 'left');
        $db2->where('ef.endorsement_id', $endorsement_id); //ad_endorsement_file_id
        $db2->where('ef.endorsement_file_id', '6');
        $q = $db2->get();
        return ($q->num_rows() < 1) ? null : $q->result();
    }

    public function getDays($table, $column = "*", $where = null, $orderColumn = '', $orderBy = 'DESC', $limit = NULL, $offset = 0)
    {
        $query = $this->db
            ->select($column)
            ->from($table)
            ->where($where)
            ->order_by($orderColumn, $orderBy)
            ->limit($limit, $offset)
            ->get();
        if ($column == "*") {
            //echo $this->last->query();
            return $query->row();
        } else if (!empty($column)) {
            return $query->row();
        } else {
            return $query->row()->$column;
        }
    
    }
}
