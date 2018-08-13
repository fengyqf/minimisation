<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mnmssession_model extends CI_Model {

    public function __construct($study_id=NULL){
        parent::__construct();
    }


    public function init($auto_redirect=TRUE){
        //do something to init the data of the operate user
        $this->load->library('session');
        $this->operate_user_id=(int)$this->session->userdata('user_id');

        //not authorized operater, redirect to somewhere
        if($auto_redirect and !$this->operate_user_id){
            redirect('/welcome/login');
        }
    }


}
