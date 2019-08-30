<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class sports extends \REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sport_model');
    }

    public function index_get($sports_id = null){
        if($sports_id > 0 ){
            $data = $this->sport_model->getSports($sports_id);
        }else{
            if(TITLE == 'STORE'){
                $data= $this->sport_model->getAllSportsOrder();
            }else{
                $data= $this->sport_model->getAllSports();
            }
        }
        $this->response($data, 200);
    }

    public function index_post(){

        if($this->post('sport_name')){

            if($this->sport_model->addSport(array('sport_name' =>$this->post('sport_name')))){
                $this->response('success', 200);
            }else{
                $this->response('Failed', 400);
            }
            exit;
        }else{
            $this->response('parameter missing', 404);
            exit;
        }

    }

    public function index_put(){
        if($this->put('sport_name') && $this->put('sport_id')){
            if($this->sport_model->updateSport($this->put('sport_id'), array( 'sport_name' =>$this->put('sport_name') ))){
                $this->response('success', 200);
            }else{
                $this->response('Failed', 400);
            }
            exit;
        }else{
            $this->response('parameter missing', 404);
            exit;
        }

    }
    public function index_delete($sports_id){
        if($sports_id > 0 ){
            if($this->sport_model->deleteSport($sports_id)){
                $this->response('success', 200);
            }else{
                $this->response('Failed', 400);
            }

            exit;
        }else{
            $this->response('parameter missing', 404);
            exit;
        }

    }
}