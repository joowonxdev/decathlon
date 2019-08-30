<?php
class apply_model extends CI_Model{
    function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //API call - get
    public function getApply($apply_id){
        $this->db->select('apply_id, sport_id, activities_id, user_num, class_name, user_name, created_at');
        $this->db->from('apply');
        $this->db->where('apply_id',$apply_id);
        $query = $this->db->get();

        if($query->num_rows() == 1)
        {
            return $query->result_array();
        }
        else
        {
            return array('empty');
        }
    }

    //API call - get list
    public function getApplyUser($user_num){
        $this->db->select('apply_id, sport_id, activities_id, user_num, class_name, user_name, created_at');
        $this->db->from('apply');
        $this->db->where('user_num',$user_num);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return array('empty');
        }
    }

    //API call - delete
    public function deleteApply($apply_id){
        $this->db->where('apply_id', $apply_id);
        if($this->db->delete('apply')){
            return true;
        }else{
            return false;
        }
    }

    //API call - add new
    public function addApply($apply_data){
        if($this->db->insert('apply', $apply_data)){
            return true;
        }else{
            return false;
        }
    }


}

