<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: joowonx
 * Date: 2019-08-07
 * Time: 오후 3:05
 */
class Index extends CI_Controller {

    public function index(){
        goto_url('/oauth/login');
    }
}