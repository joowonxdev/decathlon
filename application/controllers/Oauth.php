<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class oauth extends CI_Controller {
    private  $code, $activitiesClientID, $callbackURI, $activitiesClientSecret, $storeClientID, $storeClientSecret ;


    function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        $this->storeClientID = '5x8V69v1sRE2ASSGxcyBsA==';
        $this->storeClientSecret = 'IEriNd4GZ_aWzwXGO1vDVg==';
        $this->activitiesClientID = 'NIBFaIO9XQeuVfoSndifUw==';
        $this->activitiesClientSecret = 'cvIqhb70WAjw2DSr-yjbwA==';

        $this->callbackURI = 'http://' . $_SERVER['HTTP_HOST'] . '/decathlon/oauth/callback';


    }

    public function index(){
        goto_url('/decathlon/oauth/login');
    }

    public function login(){
        $data['activitiesURL'] = "https://bs-provider.prod.connect.eu-west-3.k8s.fewlines.net/oauth/authorize?".
        "client_id=".$this->activitiesClientID.
        "&redirect_uri=".($this->callbackURI).
        "&response_type=code";
        $this->session->set_userdata('type', 'activities');
        $this->load->view('head');
        $this->load->view('login',$data);
        $this->load->view('footer');
    }

    public function storeLogin(){
        $data['storeURL'] = "https://bs-provider.prod.connect.eu-west-3.k8s.fewlines.net/oauth/authorize?".
            "client_id=".$this->storeClientID.
            "&redirect_uri=".($this->callbackURI).
            "&response_type=code";
        $this->session->set_userdata('type', 'store');
        $this->load->view('head');
        $this->load->view('store_login',$data);
        $this->load->view('footer');
    }

    public function callback(){
        $this->load->model('user_model');

        $this->code = $this->input->get('code');
        if($this->code){
            if($this->session->userdata('type') == 'activities'){

                $postData = "client_id=".$this->activitiesClientID.
                    "&client_secret=".$this->activitiesClientSecret.
                    "&code=".$this->code.
                    "&grant_type=authorization_code".
                    "&redirect_uri=".$this->callbackURI;
            }else if($this->session->userdata('type') == 'store'){
                $postData = "client_id=".$this->storeClientID.
                    "&client_secret=".$this->storeClientSecret.
                    "&code=".$this->code.
                    "&grant_type=authorization_code".
                    "&redirect_uri=".$this->callbackURI;
            }else{
                goto_url('/decathlon/oauth/login');
            }
            // call api
            $obj = request_api($postData);
            if(property_exists($obj,'error')){ // error
                if($this->session->userdata('type') == 'activities') {
                    $this->session->set_flashdata('error', $obj->error);
                    goto_url('/decathlon/oauth/login');
                }else{
                    $this->session->set_flashdata('error', $obj->error);
                    goto_url('/decathlon/oauth/storelogin');
                }
            }else{
                $this->loginProcess($obj);
            }
        }else{
            if($this->session->userdata('type') == 'activities') {
                $this->session->set_flashdata('error', 'authorization failed.');
                goto_url('/decathlon/oauth/login');
            }else{
                $this->session->set_flashdata('error', 'authorization failed.');
                goto_url('/decathlon/oauth/storelogin');
            }
        }
    }

    public function join(){

        $this->load->view('head');
        $this->load->view('join');
        $this->load->view('footer');
    }

    public function add_user(){
        $this->load->model('user_model');
        if($this->input->post()){
            $user = $this->session->userdata('user');

            $userdata = array('user_id' => $this->input->post('userid'), 'user_name' => $this->input->post('username'), 'id' => $user['id']);

            if($user_num  = $this->user_model->addClassUser($userdata)){
                $userinfo = array('scope'=> $user['scope'], 'refresh_token' => $user['refresh_token'], 'access_token' => $user['access_token'], 'id' => $user['id'], 'exp'=> $user['exp'], 'user_id' => $userdata['user_id'], 'user_name'=> $userdata['user_name'], 'user_num'=>$user_num);
                $this->session->set_userdata('user',$userinfo);
                goto_url('/decathlon/activities');
            }else{
                $this->session->set_flashdata('error', 'join failed.');
                goto_url('/decathlon/oauth/join');
            }

        }else{
            goto_url('/decathlon/oauth/join');
        }
    }

    public function logout(){
        if($this->session->userdata('type') == 'store') {

            $this->session->unset_userdata('user');
            goto_url('/decathlon/oauth/storelogin');
        }else{

            $this->session->unset_userdata('user');
            goto_url('/decathlon/oauth/login');
        }
    }

    private function loginProcess($obj,$tokenEx=null){

        $this->load->model('user_model');
        $token = (new Parser())->parse($obj->access_token); // Parses from a string
        if($tokenEx){ // from token exchange
            if($obj->scope  == 'joowon:profile') {
                if ($token->verify(new Sha256(), $this->activitiesClientSecret)) {

                    $userdata = $this->user_model->getClassUserBYid($token->getClaim('sub'));
                    if ($userdata) {

                        $userinfo = array('scope' => $obj->scope, 'refresh_token' => $obj->refresh_token, 'access_token' => $obj->access_token, 'id' => $token->getClaim('sub'), 'exp' => $token->getClaim('exp'), 'user_num' => $userdata[0]['user_num'], 'user_id' => $userdata[0]['user_id'], 'user_name' => $userdata[0]['user_name']);

                        $this->session->set_userdata('user', $userinfo);
                        $this->user_model->updateClassUserLastLoginBYid($userinfo['id']);
                        if($this->session->userdata('type') == 'activities')
                            goto_url('/decathlon/activities');
                        else
                            goto_url('/decathlon/store');
                    } else {
                        $userinfo = array('scope' => $obj->scope, 'refresh_token' => $obj->refresh_token, 'access_token' => $obj->access_token, 'id' => $token->getClaim('sub'), 'exp' => $token->getClaim('exp'));
                        $this->session->set_userdata('user', $userinfo);
                        goto_url('/decathlon/oauth/join');
                    }

                } else {
                    $this->session->set_flashdata('error', 'access token verify failed');
                    goto_url('/decathlon/oauth/storelogin');
                }
            }else if($obj->scope  == 'joowon:activities'){

                if ($token->verify(new Sha256(), $this->storeClientSecret)) {
                    $userdata = $this->user_model->getClassUserBYid($token->getClaim('sub'));
                    if ($userdata) {

                        $userinfo = array('scope' => $obj->scope, 'refresh_token' => $obj->refresh_token, 'access_token' => $obj->access_token, 'id' => $token->getClaim('sub'), 'exp' => $token->getClaim('exp'), 'user_num' => $userdata[0]['user_num'], 'user_id' => $userdata[0]['user_id'], 'user_name' => $userdata[0]['user_name']);

                        $this->session->set_userdata('user', $userinfo);
                        $this->user_model->updateClassUserLastLoginBYid($userinfo['id']);
                        if($this->session->userdata('type') == 'store')
                            goto_url('/decathlon/store');
                        else
                            goto_url('/decathlon/activities');
                    } else {
                        $userinfo = array('scope' => $obj->scope, 'refresh_token' => $obj->refresh_token, 'access_token' => $obj->access_token, 'id' => $token->getClaim('sub'), 'exp' => $token->getClaim('exp'));
                        $this->session->set_userdata('user', $userinfo);
                        goto_url('/decathlon/oauth/join');
                    }

                } else {
                    $this->session->set_flashdata('error', 'access token verify failed');
                    goto_url('/decathlon/oauth/login');
                }
            }
        }
        if($this->session->userdata('type')  == 'activities') {

            if ($token->verify(new Sha256(), $this->activitiesClientSecret)) {
                $userdata = $this->user_model->getClassUserBYid($token->getClaim('sub'));
                if ($userdata) {

                    $userinfo = array('scope' => $obj->scope, 'refresh_token' => $obj->refresh_token, 'access_token' => $obj->access_token, 'id' => $token->getClaim('sub'), 'exp' => $token->getClaim('exp'), 'user_num' => $userdata[0]['user_num'], 'user_id' => $userdata[0]['user_id'], 'user_name' => $userdata[0]['user_name']);

                    $this->session->set_userdata('user', $userinfo);
                    $this->user_model->updateClassUserLastLoginBYid($userinfo['id']);

                    goto_url('/decathlon/activities');
                } else {
                    $userinfo = array('scope' => $obj->scope, 'refresh_token' => $obj->refresh_token, 'access_token' => $obj->access_token, 'id' => $token->getClaim('sub'), 'exp' => $token->getClaim('exp'));
                    $this->session->set_userdata('user', $userinfo);
                    goto_url('/decathlon/oauth/join');
                }

            } else {
                $this->session->set_flashdata('error', 'access token verify failed');
                goto_url('/decathlon/oauth/login');
            }
        }else if($this->session->userdata('type')  == 'store'){
            if ($token->verify(new Sha256(), $this->storeClientSecret)) {
                $userdata = $this->user_model->getClassUserBYid($token->getClaim('sub'));
                if ($userdata) {

                    $userinfo = array('scope' => $obj->scope, 'refresh_token' => $obj->refresh_token, 'access_token' => $obj->access_token, 'id' => $token->getClaim('sub'), 'exp' => $token->getClaim('exp'), 'user_num' => $userdata[0]['user_num'], 'user_id' => $userdata[0]['user_id'], 'user_name' => $userdata[0]['user_name']);

                    $this->session->set_userdata('user', $userinfo);
                    $this->user_model->updateClassUserLastLoginBYid($userinfo['id']);

                    goto_url('/decathlon/store');
                } else {
                    $userinfo = array('scope' => $obj->scope, 'refresh_token' => $obj->refresh_token, 'access_token' => $obj->access_token, 'id' => $token->getClaim('sub'), 'exp' => $token->getClaim('exp'));
                    $this->session->set_userdata('user', $userinfo);
                    goto_url('/decathlon/oauth/join');
                }

            } else {
                $this->session->set_flashdata('error', 'access token verify failed');
                goto_url('/decathlon/oauth/storelogin');
            }
        }
    }
    public function tokenExchange(){
        // call api

        $user = $this->session->userdata('user');
        if($user) {
            $postData = "grant_type=urn:ietf:params:oauth:grant-type:token-exchange".
                "&scope=".$user['scope'].
                "&subject_token=".$user['access_token'].
                "&subject_token_type=urn:ietf:params:oauth:token-type:access_token";
            $obj = request_api($postData);

            if($this->session->userdata('type') == 'activities'){
                $this->session->set_userdata('type','store');
                $this->session->unset_userdata('user');
            }else if($this->session->userdata('type') == 'store'){
                $this->session->set_userdata('type','activities');
                $this->session->unset_userdata('user');
            }
            $this->loginProcess($obj,true);

        }else{
            if($this->session->userdata('type') == 'activities') {
                $this->session->set_flashdata('error', 'authorization failed.');
                goto_url('/decathlon/oauth/login');
            }else{
                $this->session->set_flashdata('error', 'authorization failed.');
                goto_url('/decathlon/oauth/storelogin');
            }
        }

    }

}

