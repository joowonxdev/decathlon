<?php
class sport_model extends CI_Model{
    function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    //API call - get
    public function getSports($sport_id){
        $this->db->select('sport_id, sport_name, created_at, updated_at');
        $this->db->from('sports');
        $this->db->where('sport_id',$sport_id);
        $query = $this->db->get();

        if($query->num_rows() == 1)
        {
            return $query->result_array();
        }
        else
        {
            return 0;
        }
    }
    //API call - get all
    public function getAllSports(){
        $this->db->select('sport_id, sport_name, created_at, updated_at');
        $this->db->from('sports');
        $this->db->order_by("sport_id", "desc");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return 0;
        }
    }

    //API call - get all
    public function getAllSportsOrder(){
        $this->db->select('a.sport_id, a.sport_name, a.created_at, a.updated_at');
        $this->db->from('sports a');
        $this->db->join('apply b', 'a.sport_id = b.sport_id and b.user_num = 1 ', 'left');
        $this->db->group_by('a.sport_id');
        $this->db->order_by("(b.sport_id is null)", "asc");
        $this->db->order_by("b.sport_id", "desc");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return 0;
        }
    }


    //API call - delete 
    public function deleteSport($sport_id){
        $this->db->where('sport_id', $sport_id);
        if($this->db->delete('sports')){
            return true;
        }else{
            return false;
        }
    }

    //API call - add new
    public function addSport($sport_data){
        if($this->db->insert('sports', $sport_data)){
            return true;
        }else{
            return false;
        }
    }

    //API call - update 
    public function updateSport($sport_id, $sport_data){
        $this->db->where('sport_id', $sport_id);
        $this->db->set('updated_at', 'NOW()', false);
        if($this->db->update('sports', $sport_data)){
            return true;
        }else{
            return false;
        }
    }
}