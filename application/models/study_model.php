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
            ->select('id,name,bias,group_count,owner_uid,separated_by_center,access_token,from_unixtime(time) as time')
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
            $study['separated_by_center']=0;
            $study['time']='';
            $study['access_token']=NULL;
        }
        return $study;
    }

    public function get_factors($study_id=NULL){
        //$this->db->
        //
    }


    public function get_allocation_count($study_id=0){
        //计算allocation总条数
        $this->db->from('allocation a')
                 ->join('group g','g.id=a.group_id','inner')
                  ->where('g.study_id',$study_id);
        $rs_count=$this->db->count_all_results();
        return $rs_count;
    }


    public function get_factor_count($study_id=0){
        $this->db->from('factor')
                 ->where('study_id',$study_id);
        return $this->db->count_all_results();
    }


    public function get_centers($study_id=NULL){
        $this->db
             ->select('id as center_id,name as center_name')
             ->from('center')
             ->where('study_id',$study_id);

        $query=$this->db->get();
        $centers=array();
        foreach($query->result_array() as $row) {
            $centers[$row['center_id']]=$row;
        }
        return $centers;
    }

    public function get_center_by_name($study_id=NULL,$name=''){
        $name= is_null($name) ? '' : trim($name);
        $this->db
             ->select('id,name')
             ->from('center')
             ->where('study_id',$study_id)
             ->where('name',$name);
        $query=$this->db->get();
        if($query->num_rows()==0){
            $data=array('study_id'=>$study_id,'name'=>$name);
            $this->db->insert('center',$data);
            $insert_id=$this->db->insert_id();
            return array('center_id'=>$insert_id,'center_name'=>$name);
        }else{
            $row=$query->row_array();
            return array('center_id'=>$row['id'],'center_name'=>$row['name']);
        }
    }

    public function get_center_id_by_name($study_id=NULL,$name=''){
        $center=$this->get_center_by_name($study_id,$name);
        return $center['center_id'];
    }

    public function get_study_id_by_access_token($access_token){
        if(!$access_token or count($access_token) < 10){
            return 0;
        }
        $this->db
             ->select('id,name')
             ->from('study')
             ->where('access_token',$access_token);
        $query=$this->db->get();
        if($query->num_rows()==0){
            return 0;
        }else{
            $row=$query->row_array();
            return $row['id'];
        }
    }

}

