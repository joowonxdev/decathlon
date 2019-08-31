<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class JWTAuth {

    protected $storeClientID = '5x8V69v1sRE2ASSGxcyBsA==';
    protected $activitiesClientID = 'NIBFaIO9XQeuVfoSndifUw==';

    private $token ;

    public function __construct()
    {
        $this->CI = & get_instance();
    }

    function decode($obj){
        $this->token = (new Parser())->parse($obj->access_token);
        return $this->token;
    }


    function token_verify($type){
        if($type == 'activities'){
            return $this->token->verify(new Sha256(), $this->activitiesClientSecret);
        }else if($type == 'store'){
            return $this->token->verify(new Sha256(), $this->storeClientSecret);
        }else{
            return false;
        }
    }


}