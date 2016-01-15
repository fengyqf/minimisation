<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Study_model extends CI_Model {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct($study_id=NULL){
        parent::__construct();

        //当前操作的用户，可以挂接任何用户系统
        $this->load->database('default');
    }


    public function get($study_id=NULL){
        //检测当前操作用户是否有操作study_id的权限
        $this->db
            ->select('id,name,bias,group_count,owner_uid,from_unixtime(time) as time')
            ->from('study')
            ->where('id',$study_id)
            ->limit(1);
        $query=$this->db->get();
        $study=array();
        if($row=$query->row_array()){
            $row['bias']=$row['bias']/100;
            $study=$row;
        }else{
            $study['id']=0;
            $study['name']=NULL;
            $study['bias']=0;
            $study['owner_uid']=-1;
            $study['time']='';
        }
        return $study;
    }

    public function get_factors($study_id=NULL){
        //$this->db->
        //
    }
}
