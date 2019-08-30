<?php

require APPPATH . 'libraries/REST_Controller.php';
class stores extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('store_model');
    }


    public function index_get($type=null, $id = null){
        if($type=='list'){
            $data = $this->store_model->getProductList($id);
            $data['type'] = 'storeList';
        }else if($type== 'product'){
            $data = $this->store_model->getProduct($id);
            $data['type'] = 'storeProduct';
        }else{
            $data= $this->store_model->getAllProduct();
            $data['type'] = 'storeAll';
        }
        $this->response($data, 200);
    }

    public function index_post(){

        if($this->post('product_name') && $this->post('sport_id') && $this->post('description') && $this->post('product_price')){

            if($this->store_model->addProduct(
                    array('product_name' =>$this->post('product_name'),
                            'sport_id' =>$this->post('sport_id'),
                            'description' =>$this->post('description'),
                            'product_price' => $this->post('product_price')
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
        if($this->put('product_id') && $this->put('product_name') && $this->put('sport_id') && $this->put('description') && $this->put('product_price')){
            if($this->store_model->updateProduct($this->put('product_id'),
                array( 'product_name' =>$this->put('product_name'),
                    'sport_id' =>$this->put('sport_id'),
                    'description' =>$this->put('description'),
                    'product_price' => $this->put('product_price') )
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
    public function index_delete($product_id){
        if($product_id > 0 ){
            if($this->store_model->deleteProduct($product_id)){
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
