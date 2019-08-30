<?php
class store_model extends CI_Model{
    function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //API call - get
    public function getProduct($product_id){
        $this->db->select('product_id, sport_id, product_name, description, product_price, created_at, updated_at');
        $this->db->from('product');
        $this->db->where('product_id',$product_id);
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
    public function getProductList($sport_id){
        $this->db->select('product_id, sport_id, product_name, description, product_price, created_at, updated_at');
        $this->db->from('product');
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
    public function getAllProduct(){
        $this->db->select('product_id, sport_id, product_name, description, product_price, created_at, updated_at');
        $this->db->from('product');
        $this->db->order_by("product_id", "desc");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return array('empty');
        }
    }

    //API call - delete
    public function deleteProduct($product_id){
        $this->db->where('product_id', $product_id);
        if($this->db->delete('product')){
            return true;
        }else{
            return false;
        }
    }

    //API call - add new
    public function addProduct($product_data){
        if($this->db->insert('product', $product_data)){
            return true;
        }else{
            return false;
        }
    }

    //API call - update
    public function updateProduct($product_id, $product_data){
        $this->db->where('product_id', $product_id);
        $this->db->set('updated_at', 'NOW()', false);
        if($this->db->update('product', $product_data)){
            return true;
        }else{
            return false;
        }
    }

}

