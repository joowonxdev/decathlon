<?php
class user_model extends CI_Model{
    function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //get classuser
    public function getClassUserBYnum($user_num){
        $this->db->select('user_num, user_id, user_name, id, last_login, created_at');
        $this->db->from('classUser');
        $this->db->where('user_num',$user_num);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    //get classuser
    public function getClassUserBYid($id){
        $this->db->select('user_num, user_id, user_name, id, last_login, created_at');
        $this->db->from('classUser');
        $this->db->where('id',$id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    //get classuser
    public function getClassUserBYuserid($user_id){
        $this->db->select('user_num, user_id, user_name, id, last_login, created_at');
        $this->db->from('classUser');
        $this->db->where('user_id',$user_id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    //delete classuser
    public function deleteClassUser($user_num){
        $this->db->where('user_num', $user_num);
        if($this->db->delete('classUser')){
            return true;
        }else{
            return false;
        }
    }

    //add new classuser
    public function addClassUser($user_data){
        if($this->db->insert('classUser', $user_data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function updateClassUserLastLoginBYid($id){
        $this->db->where('id', $id);
        $this->db->set('last_login', 'NOW()', false);
        if($this->db->update('classUser')){
            return true;
        }else{
            return false;
        }
    }


    //get sportUser
    public function getSportUserBYnum($user_num){
        $this->db->select('user_num, user_id, user_name, id, last_login, created_at');
        $this->db->from('sportUser');
        $this->db->where('user_num',$user_num);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    //get user
    public function getSportUserBYid($id){
        $this->db->select('user_num, user_id, user_name, id, last_login, created_at');
        $this->db->from('sportUser');
        $this->db->where('id',$id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    //get user
    public function getSportUserBYuserid($user_id){
        $this->db->select('user_num, user_id, user_name, id, last_login, created_at');
        $this->db->from('sportUser');
        $this->db->where('user_id',$user_id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    //delete
    public function deleteSportUser($user_num){
        $this->db->where('user_num', $user_num);
        if($this->db->delete('sportUser')){
            return true;
        }else{
            return false;
        }
    }

    //add new
    public function addSportUser($user_data){
        if($this->db->insert('sportUser', $user_data)){
            return true;
        }else{
            return false;
        }
    }

    public function updateSportUserLastLogin($id){
        $this->db->where('id', $id);
        $this->db->set('last_login', 'NOW()', false);
        if($this->db->update('sportUser', $id)){
            return true;
        }else{
            return false;
        }
    }

}