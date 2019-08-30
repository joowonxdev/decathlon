<?php
require APPPATH . 'libraries/REST_Controller.php';

class activitie extends REST_Controller {

    private $data = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('activitie_model');
    }

    public function index_get($type=null, $id = null){
        if($type=='list'){
            $this->data = $this->activitie_model->getClassList($id);
        }else if($type== 'class'){
            $userInfo = $this->session->userdata('user');

            $this->data = $this->activitie_model->getClass($id,$userInfo['user_num']);

        }else{
            $this->data= $this->activitie_model->getAllClass();

        }
        $this->response($this->data, 200);
    }

    public function index_post(){

        if($this->post('class_name') && $this->post('sport_id') && $this->post('description') && $this->post('class_price')){

            if($this->activitie_model->addClass(
                array('class_name' =>$this->post('class_name'),
                    'sport_id' =>$this->post('sport_id'),
                    'description' =>$this->post('description'),
                    'class_price' => $this->post('class_price')
                )
            ))
            {
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
        if($this->put('activities_id') && $this->put('class_name') && $this->put('sport_id')
            && $this->put('description') && $this->put('class_price')){
            if($this->activitie_model->updateClass($this->put('activities_id'),
                array( 'class_name' =>$this->put('class_name'),
                    'sport_id' =>$this->put('sport_id'),
                    'description' =>$this->put('description'),
                    'class_price' => $this->put('class_price') )
            ))
            {
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

    public function index_delete($activities_id){
        if($activities_id > 0 ){
            if($this->activitie_model->deleteClass($activities_id)){
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