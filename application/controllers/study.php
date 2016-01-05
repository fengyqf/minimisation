<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Study extends CI_Controller {

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
    public function __construct(){
        parent::__construct();

        //当前操作的用户，可以挂接任何用户系统
        $this->operate_user_id=7;
        $this->load->database('default');
        //$this->load->helper('language');
        $this->lang->load('common');

        $this->study_id=(int)($this->input->get('study_id'));
        //检测当前操作用户是否有操作study_id的权限
        $this->db
            ->select('id,name,bias,group_count,owner_uid')
            ->from('study')
            ->where('owner_uid',$this->operate_user_id)
            ->where('id',$this->study_id)
            ->limit(1);
        $query=$this->db->get();
        if($row=$query->row_array()){
            $study_name=$row['name'];
        }else{
            //echo('study not exists');
            $this->study_id=0;
        }
    }


    public function index()
    {
        //注意检测当前操作用户是否有操作study_id的权限
        $this->db
            ->select('id,name,bias,group_count,owner_uid,from_unixtime(time) as time')
            ->from('study')
            ->where('owner_uid',$this->operate_user_id)
            ->order_by('id','desc');
        $query=$this->db->get();
        $studys=array();
        foreach($query->result_array() as $row){
            $row['edit_link']=site_url('study/edit?id='.$row['id']);
            $row['groups_link']=site_url('group/?study_id='.$row['id']);
            $row['factors_link']=site_url('factor/?study_id='.$row['id']);
            $row['layers_link']=site_url('layer/?study_id='.$row['id']);
            $row['allocations_link']=site_url('allocation/?study_id='.$row['id']);
            $row['bias']=$row['bias']/100;
            $studys[]=$row;
        }
        //var_dump($studys);
        $data['studys']=$studys;
        $data['links']['add']=site_url("/study/add");
        $this->load->view('study/view',$data);
    }


    public function edit($hay=NULL){
        $edit_id=0;
        $default_data=NULL;
        if(is_numeric($hay)){
            $edit_id=(int)$hay;
        }elseif(is_array($hay)){
            $default_data=$hay;
        }
        $study=array(
            'id'=>$edit_id,
            'name'=>isset($default_data['name']) ? $default_data['name'] : '' ,
            'bias'=>isset($default_data['bias']) ? $default_data['bias'] : '0.8',
            'group_count'=>isset($default_data['group_count']) ? $default_data['group_count'] : 2,
            'group'=>array(),
            );
        //var_dump($studys);
        $data['study']=$study;
        $data['form_action']=site_url("/study/add_do");
        $this->load->view('study/add',$data);
    }


    public function add($hay=NULL){
        $this->edit($hay);
    }


    public function add_do(){
        //
        $bias=$this->input->post('bias') * 100;
        if($bias<=0){
            $bias=$this->config->item('default_bias');
        }
        $data=array(
            'bias'=>$bias,
            'time'=>time(),
            'owner_uid'=>$this->operate_user_id,
            );
        $id=(int)$this->input->post('id');
        if($id<=0){
            //insert
            $this->db->insert('study',$data);
            $id=$this->db->insert_id();
        }else{
            //update
            //验证该id所有者是当前用户
            $this->db->where('id',$id)
                     ->where('owner_uid',$this->operate_user_id);
            $this->db->update('study',$data);
        }

        //重定向到group管理中
        redirect('study/group?study_id='.$id);
    }


    public function group(){
        $study_id=$this->input->get('study_id');
        //检测所有权限
        $this->db
            ->select('id,name,from_unixtime(time) as time')
            ->from('study')
            ->where('owner_uid',$this->operate_user_id)
            ->order_by('id','desc');
        $query=$this->db->get();
        if($study=$query->row_array()){
            //读取group列表
            $this->db->flush_cache();
            $this->db->select('id,name')
                     ->from('group')
                     ->where('study_id',$study_id)
                     ->order_by('id','asc');
            $query=$this->db->get();
            $groups=array();
            foreach($query->result_array() as $row){
                $groups[]=$row;
            }
            $data['groups']=$groups;
            $data['study']=$study;
            $data['form_action']=site_url('study/group_save');
            //var_dump($data);
            $this->load->view('study/group',$data);
        }else{
            redirect('study/');
        }
    }


    public function group_save(){
        $study_id=$this->input->post('study_id');
        $groups=$this->input->post('groups');
        $group_new=$this->input->post('group_new');
        //修改部分$groups
        if(count($groups)>=1){
            $this->db
                 ->select('s.id as study_id,s.name as study_name,g.id as group_id,g.name as group_name')
                 ->from('group g')
                 ->join('study s','s.id=g.study_id','inner')
                 ->where('s.owner_uid',$this->operate_user_id)
                 ->where_in('g.id',array_keys($groups))
                 ->order_by('g.id','asc');
            $query=$this->db->get();
            //var_dump($this->db->last_query());
            foreach($query->result_array() as $row ){
                //按上面带权限限定的查询结果，更新相应group_id对应的数据，
                //  更新为POST['groups']中对应值，事实上仅group.name
                if(isset($groups[$row['group_id']])){
                    $this->db->where('id',$row['group_id'])
                         ->update('group',array(
                                'name'=>$groups[$row['group_id']]
                                ));
                    //var_dump($groups,$group_new);
                }
            }
        }
        //新添加部分$group_new
        if($group_new){
            $data=array();
            foreach ($group_new as $item) {
                if($item){
                    $data[]=array('name'=>$item,'study_id'=>$study_id);
                }
            }
            if($data){
                $this->db->insert_batch('group',$data);
            }
        }
        redirect('study/'.$study_id);
    }

}
