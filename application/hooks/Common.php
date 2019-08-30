<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class _Common {
    private $CI;

    function __construct()
    {
        $this->CI =& get_instance();

        if(!isset($this->CI->session)){  //Check if session lib is loaded or not
            $this->CI->load->library('session');  //If not loaded, then load it here
        }
    }


    function index() {

        $this->CI =& get_instance();

        $url = $this->CI->uri->segment(1);
        $curl = $this->CI->uri->segment(2);
        $user = $this->CI->session->userdata('user');
        $type = $this->CI->session->userdata('type');



        if($url != 'oauth'){

            if(!$user){
                if($type == 'store'){
                    goto_url('/decathlon/oauth/storelogin');
                }else{
                    goto_url('/decathlon/oauth/login');
                }

            }

            if($user){ // 메뉴 세션상태 접속등 이상 상태 조정

                if(!isset($user['user_num'])){ //비정상 접속
                    $this->CI->session->unset_userdata('user');
                    if($type =='store'){
                        goto_url('/decathlon/oauth/storelogin');
                    }else{
                        goto_url('/decathlon/oauth/login');
                    }
                }

                define('USER_NAME', $user['user_name']);
                define("MENU_TOP", true);
                if($type == 'activities' ){
                    define("TITLE", "ACTIVITIES");
                    define("MOVETO", "STORE");
                    if( $url == "store" ){
                        goto_url('/decathlon/activities');
                    }
                }

                if($type == 'store' ){
                    define("TITLE", "STORE");
                    define("MOVETO", "ACTIVITIES");
                    if( $url == "activities" ){
                        goto_url('/decathlon/store');
                    }
                }
            }

        }else{
            define("MENU_TOP", false);
            if($curl == "login" || $curl == "storelogin"  ){
                if($user && isset($user['user_num'])){
                    if ($type == 'activities') {
                        goto_url('/decathlon/activities');
                    }else if ($type == 'store') {
                        goto_url('/decathlon/store');
                    }
                }
            }
        }
    }
}