<?php
require APPPATH . 'libraries/REST_Controller.php';

class apply extends REST_Controller {

    private $data = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('apply_model');
        $this->load->model('activitie_model');
    }

    public function index_get($type=null, $id = null){
        if($type=='user'){
            $this->data = $this->apply_model->getApplyUser($id);
            $this->data['type'] = 'applyUser';
        }else if($type=='id'){
            $this->data= $this->apply_model->getApply($id);
            $this->data['type'] = 'applyID';
        }
        $this->response($this->data, 200);
    }

    public function index_post(){

        if( $this->post('activities_id')){
            $temp = $this->activitie_model->getClass($this->post('activities_id'));
            $actData = $temp[0];
            $userInfo = $this->session->userdata('user');
            if($actData && $userInfo){
                if($this->apply_model->addApply(
                    array('sport_id' =>$actData['sport_id'],
                        'activities_id' =>$actData['activities_id'],
                        'user_num' =>$userInfo['user_num'],
                        'class_name' => $actData['class_name'],
                        'user_name' => $userInfo['user_name']
                    )
                )){
                    $this->response('success', 200);
                }else{
                    $this->response('Failed', 400);
                }
            }else{
                $this->response('data missing', 400);
            }

            exit;
        }else{
            $this->response('parameter missing', 404);
            exit;
        }

    }

    public function index_delete($apply_id){
        if($apply_id > 0 ){
            if($this->apply_model->deleteApply($apply_id)){
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