<?php
class activitie_model extends CI_Model{
    function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //API call - get
    public function getClass($activities_id, $user_num ){
        $this->db->select('a.activities_id, a.sport_id, a.class_name, a.description, a.class_price, a.created_at, a.updated_at, b.user_num, b.user_name');
        $this->db->from('activities a');
        $this->db->join('apply b', 'a.activities_id = b.activities_id and b.user_num='.$user_num, 'left');
        $this->db->where('a.activities_id',$activities_id);
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
    public function getClassList($sport_id){
        $this->db->select('activities_id, sport_id, class_name, description, class_price, created_at, updated_at');
        $this->db->from('activities');
        $this->db->where('sport_id',$sport_id);
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
    //API call - get all
    public function getAllClass(){
        $this->db->select('activities_id, sport_id, class_name, description, class_price, created_at, updated_at');
        $this->db->from('activities');
        $this->db->order_by("activities_id", "desc");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return array('empty');
        }
    }

    //API call - delete
    public function deleteClass($activities_id){
        $this->db->where('activities_id', $activities_id);
        if($this->db->delete('activities')){
            return true;
        }else{
            return false;
        }
    }

    //API call - add new
    public function addClass($activitie_data){
        if($this->db->insert('activities', $activitie_data)){
            return true;
        }else{
            return false;
        }
    }

    //API call - update
    public function updateClass($activities_id, $activitie_data){
        $this->db->where('activities_id', $activities_id);
        $this->db->set('updated_at', 'NOW()', false);
        if($this->db->update('activities', $activitie_data)){
            return true;
        }else{
            return false;
        }
    }

}

