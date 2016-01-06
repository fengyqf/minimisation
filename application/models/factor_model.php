<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Factor_model extends CI_Model {

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


    public function get($hay=NULL){
        $study_id=$factor_id=0;
        if(isset($hay['study_id'])){
            $study_id=(int)$hay['study_id'];
        }elseif(isset($hay['factor_id'])){
            $factor_id=(int)$hay['factor_id'];
        }elseif(isset($hay['id'])){
            $factor_id=(int)$hay['id'];
        }else{
            return NULL;
        }

        $data_factors=array();      //factor-layer两级数组
        $factor_ids=array();        //factor_id一维数组
        $this->db->select('id as factor_id,name as factor_name,weight')
                 ->from('factor');
        if($study_id){
            $this->db->where('study_id',$study_id);
        }
        if($factor_id){
            $this->db->where('id',$study_id);
        }
        $this->db->order_by('id','asc')->limit(100);    //假定最大100个factors
        $query=$this->db->get();
        foreach ($query->result_array() as $row) {
            $row['layers_link']=site_url('factor/layer?factor_id='.$row['factor_id']);
            $row['del_link']=site_url('factor/del/'.$row['factor_id']);
            $row['edit_link']=site_url('factor/edit/'.$row['factor_id']);
            $data_factors[$row['factor_id']]=$row;
            $factor_ids[]=$row['factor_id'];
        }

        //根据$factor_ids查询所有相关layer, 合并到data_factors里
        if($factor_ids){
            $this->db->select('id as layer_id,name as layer_name,factor_id')
                     ->from('layer')
                     ->where_in('factor_id',$factor_ids)
                     ->order_by('id','asc');
            $query=$this->db->get();
            foreach ($query->result_array() as $row) {
                //var_dump($row);
                $data_factors[$row['factor_id']]['layers'][]=array(
                        'layer_id'   => $row['layer_id'],
                        'layer_name' => $row['layer_name'],
                    );
            }
        }

        return $data_factors;

    }

}
