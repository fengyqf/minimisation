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


    /** 所读取指定study_id下的所有factor-layer的层级数据
            如果指定allocation_statistic参数，再增加每个layer计数
                即 self::get() 与 self:: allocation_statistic() 的组合
    */
    public function get($hay=NULL,$allocation_statistic=FALSE){
        $study_id=$factor_id=0;
        if(isset($hay['study_id'])){
            $study_id=(int)$hay['study_id'];
        }elseif(isset($hay['factor_id'])){
            $factor_id=(int)$hay['factor_id'];
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
            $row['layers']=array();
            $data_factors[$row['factor_id']]=$row;
            $factor_ids[]=$row['factor_id'];
        }

        //根据$factor_ids查询所有相关layer, 合并到data_factors里
        if($allocation_statistic){
            $gl_cnt=$this->allocation_statistic($study_id);
            //var_dump($gl_cnt);
            $group_ids=array_keys($gl_cnt);
            //var_dump($group_ids);
        }

        if($factor_ids){
            $this->db->select('id as layer_id,name as layer_name,factor_id')
                     ->from('layer')
                     ->where_in('factor_id',$factor_ids)
                     ->order_by('id','asc');
            $query=$this->db->get();
            foreach ($query->result_array() as $row) {
                //var_dump($row);
                $tmp['layer_id']   = $row['layer_id'];
                $tmp['layer_name'] = $row['layer_name'];
                if($allocation_statistic){
                    foreach ($group_ids as $group_id) {
                        $tmp['group_cnt'][$group_id]=
                            isset($gl_cnt[$group_id][$row['layer_id']])
                                ? $gl_cnt[$group_id][$row['layer_id']] : 0 ;
                    }
                }
                $data_factors[$row['factor_id']]['layers'][]=$tmp;
            }
        }

        return $data_factors;
    }


    /** 统计指定study_id下所有layer的计数，存储到层级数组中
            两维： array[group_id][layer_id]
            计数为0的kayer_id可能没有相应数据，故使用时要先判断存在性
    */
    public function allocation_statistic($study_id){
        $this->db->select('p.group_id,p2l.`layer_id`,count(p2l.`allocation_id`) as cnt')
                 ->from('allocation2layer p2l')
                 ->join('layer l','l.id=p2l.layer_id','inner')
                 ->join('factor f','f.id=l.factor_id','inner')
                 ->join('allocation p','p.id=p2l.allocation_id')
                 ->where('f.study_id',$study_id)
                 ->group_by(array('p.group_id','p2l.`layer_id`'));
        $query=$this->db->get();
        $gl_cnt=array();
        foreach($query->result_array() as $row){
            //var_dump($row);
            $gl_cnt[$row['group_id']][$row['layer_id']]=(int)$row['cnt'];
        }
        return $gl_cnt;
    }


    /** 根据关联数组读取相应study数据
    */
    public function get_study($hay){
        $this->db->flush_cache();
        if(isset($hay['layer_id'])){
            $q=1;
            $this->db->select('s.id,s.name,s.bias,s.group_count,s.owner_uid,from_unixtime(s.time) as time')
                     ->from('layer l')
                     ->join('factor f','f.id=l.factor_id','inner')
                     ->join('study s','s.id=f.study_id','inner')
                     ->where('l.id',(int)$hay['layer_id']);
        }
        if(isset($hay['factor_id'])){
            $q=1;
            $this->db->select('s.id,s.name,s.bias,s.group_count,s.owner_uid,from_unixtime(s.time) as time')
                     ->from('factor f')
                     ->join('study s','s.id=f.study_id','inner')
                     ->where('f.id',(int)$hay['factor_id']);
        }
        if(isset($hay['study_id'])){
            $q=1;
            $this->db->select('s.id,s.name,s.bias,s.group_count,s.owner_uid,from_unixtime(s.time) as time')
                     ->from('study s')
                     ->where('s.id',(int)$hay['factor_id']);
        }
        if($q!=1){
            return NULL;
        }else{
            $query=$this->db->get();
            if($row=$query->row_array()){
                return $row;
            }else{
                return NULL;
            }
            return $study;
        }
    }


}
