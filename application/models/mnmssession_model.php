<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mnmssession_model extends CI_Model {

    public function __construct($study_id=NULL){
        parent::__construct();
    }


    public function init(){
        //do something to init the data of the operate user
        $this->operate_user_id=7;

        //not authorized operater, redirect to somewhere
        if(!$this->operate_user_id){
            redirect('/');
        }
    }


}
