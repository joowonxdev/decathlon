<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;

public class JWTAuth extends \CI_Controller {

    const storeClientID = '5x8V69v1sRE2ASSGxcyBsA==';
    const storeClientSecret = 'IEriNd4GZ_aWzwXGO1vDVg==';

    const activitiesClientID = 'NIBFaIO9XQeuVfoSndifUw==';
    const activitiesClientSecret = 'cvIqhb70WAjw2DSr-yjbwA==';

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
}