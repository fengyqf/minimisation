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
        $this->data['bootstrap']=$this->load->view('part/bootstrap', NULL, true);
        $this->data['site_name']=$this->config->item('site_name');
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
        $studies=array();
        foreach($query->result_array() as $row){
            $row['groups_link']=site_url('study/group?id='.$row['id']);
            $row['detail_link']=site_url('study/'.$row['id']);
            $row['edit_link']=site_url('study/edit/'.$row['id']);
            $row['del_link']=site_url('study/del?id='.$row['id']);
            $row['groups_link']=site_url('study/group?study_id='.$row['id']);
            $row['factors_link']=site_url('factor/?study_id='.$row['id']);
            $row['layers_link']=site_url('layer/?study_id='.$row['id']);
            $row['allocations_link']=site_url('allocation/?study_id='.$row['id']);
            $row['allocation_add_link']=site_url('allocation/add?study_id='.$row['id']);
            $row['bias']=$row['bias']/100;
            $studies[]=$row;
        }
        //var_dump($studies);
        $data['studies']=$studies;
        $data['links']['add']=site_url("/study/add");
        $data=array_merge($this->data,$data);
        $this->load->view('study/view',$data);
    }


    public function _edit($hay=NULL){
        $default_data=NULL;
        if(is_numeric($hay)){
            $edit_id=(int)$hay;
        }elseif(is_array($hay)){
            $default_data=$hay;
        }

        if(isset($edit_id) && $edit_id > 0) {
            $this->load->model('study_model');
            $study=$this->study_model->get($edit_id);
            //检查所有权
            if($study['owner_uid'] != $this->operate_user_id){
                var_dump($study['owner_uid'] , $this->operate_user_id);
                //redirect('study/');
            }
        }else{
            $study=array(
                'id'=>isset($edit_id) ? (int)$edit_id : 0 ,
                'name'=>isset($default_data['name']) ? $default_data['name'] : '' ,
                'bias'=>isset($default_data['bias']) ? $default_data['bias'] : '0.8',
                'group_count'=>isset($default_data['group_count']) ? $default_data['group_count'] : 2,
                );
        }

        if(!isset($study['study_id'])){
            $study['study_id']=$study['id'];
        }
        if(!isset($study['groups'])){
            $study['groups']=array();
        }
        $data['study']=$study;
        $data['form_action']=site_url("/study/add_do");

        $study_id=$study['id'];
        $data['links']['edit']=site_url("/study/edit/".$study_id);
        $data['links']['detail_link']=site_url("/study/".$study_id);
        $data['links']['factors']=site_url("factor/?study_id=".$study_id);
        $data['links']['view']=site_url("/study/");
        $data['links']['add']=site_url("/study/add");
        $data['links']['factor_add']=site_url('factor/add?study_id='.$study_id);
        $data['links']['groups_edit_link']=site_url("/study/group?study_id=".$study_id);

        $data=array_merge($this->data,$data);
        $this->load->view('study/add',$data);
    }


    public function add($hay=NULL){
        $this->_edit($hay);
    }


    public function edit($study_id=NULL){
        if(!$study_id){
            $study_id=$this->input->get('id');
        }
        if(!$study_id=(int)$study_id){
            redirect('study/');
        }
        $this->_edit($study_id);
    }


    public function add_do(){
        //
        $bias=$this->input->post('bias') * 100;
        $name=$this->input->post('name');
        if(!$name){
            $name=lang('default_study_name');
        }
        //var_dump($bias);
        if($bias<=0){
            $bias=$this->config->item('default_bias') * 100;
        }
        $data=array(
            'name'=>$name,
            'bias'=>$bias,
            'time'=>time(),
            'owner_uid'=>$this->operate_user_id,
            );
        $id=(int)$this->input->post('id');
        if($id<=0){
            //insert
            $this->db->insert('study',$data);
            $id=$this->db->insert_id();
            //不管是否指定了 in_add_guide 都重定向到group管理中
            redirect('study/group?in_add_guide=1&study_id='.$id);
        }else{
            //update
            //验证该id所有者是当前用户
            $this->load->model('study_model');
            $study=$this->study_model->get($id);
            if(isset($study['owner_uid']) && $study['owner_uid']==$this->operate_user_id){
                unset($data['owner_uid']);
                $this->db->where('id',$id)
                         ->where('owner_uid',$this->operate_user_id);
                $this->db->update('study',$data);
                redirect('study/'.$id);
            }
        }
        redirect('study/');
    }


    public function detail($id=NULL){
        if(!$id=(int)$id){
            redirect('study/');
        }
        $study_id=$id;
        //注意检测当前操作用户是否有操作study_id的权限
        $this->db
            ->select('id,name,bias,group_count,owner_uid,from_unixtime(time) as time')
            ->from('study')
            ->where('id',$id)
            ->where('owner_uid',$this->operate_user_id)
            ->limit(1);
        $query=$this->db->get();
        $study=array();
        if($row=$query->row_array()){
            $row['edit_link']=site_url('study/edit/'.$row['id']);
            $row['groups_link']=site_url('study/group?study_id='.$row['id']);
            $row['factors_link']=site_url('factor/?study_id='.$row['id']);
            $row['layers_link']=site_url('layer/?study_id='.$row['id']);
            $row['allocations_link']=site_url('allocation/?study_id='.$row['id']);
            $row['allocation_add_link']=site_url('allocation/add?study_id='.$row['id']);
            $row['bias']=$row['bias']/100;
            $study=$row;
        }else{
            redirect('study/');
        }
        $this->db->flush_cache();
        $this->db->select('id,name')
                 ->from('group')
                 ->where('study_id',$study_id)
                 ->order_by('id','asc');
        $query=$this->db->get();
        $groups=array();
        $group_ids=array();
        foreach($query->result_array() as $row){
            $groups[]=$row;
            $group_ids[]=$row['id'];
        }
        $data['groups']=$groups;

        $data_factors=array();      //factor-layer两级数组
        $factor_ids=array();        //factor_id一维数组
        $this->db->select('id as factor_id,name as factor_name,weight')
                 ->from('factor')
                 ->where('study_id',$study_id)
                 ->order_by('id','asc');
        $query=$this->db->get();
        foreach ($query->result_array() as $row) {
            $row['weight']=$row['weight']/100;
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

        //allocation计数
        $allocations_count=0;
        if($group_ids){
            $allocations_count=$this->db->where_in('group_id',$group_ids)
                 ->count_all_results('allocation');
        }

        $data['study']=$study;
        $data['factors']=$data_factors;
        $data['allocations_count']=$allocations_count;
        $data['links']['edit']=site_url("/study/edit/".$study_id);
        $data['links']['detail_link']=site_url("/study/".$study_id);
        $data['links']['factors']=site_url("factor/?study_id=".$study_id);
        $data['links']['view']=site_url("/study/");
        $data['links']['add']=site_url("/study/add");
        $data['links']['factor_add']=site_url('factor/add?study_id='.$study_id);
        $data['links']['groups_edit_link']=site_url("/study/group?study_id=".$study_id);
        $data=array_merge($this->data,$data);
        $this->load->view('study/detail',$data);
    }


    public function del($id=NULL){
        if(!$id){
            $id=$this->input->get('id');
        }
        if(!$id){
            redirect('study/');
        }
        $study_id=$id;
        $this->load->model('study_model');
        $study=$this->study_model->get($id);
        if(!isset($study['owner_uid']) or $study['owner_uid']!=$this->operate_user_id){
            redirect('study/');
        }
        //删除如下表中相关数据 group,factor,layer,allocation,allocation2layer,study

        //删除a2l,layer,factor 三表中相应数据
        $this->db->trans_start();
        $sql="delete a FROM `{$this->db->dbprefix}allocation` a
                INNER JOIN `{$this->db->dbprefix}allocation2layer` a2l ON a.id=a2l.allocation_id
                INNER JOIN `{$this->db->dbprefix}layer` l ON a2l.layer_id=l.id
                INNER JOIN `{$this->db->dbprefix}factor` f ON f.id = l.factor_id
                WHERE f.study_id={$study_id}";
        $this->db->query($sql,array($id));
        //echo($this->db->last_query());
        //echo("\nlines: ".$this->db->affected_rows()."\n\n");

        $sql="delete a2l FROM `{$this->db->dbprefix}allocation2layer` a2l
                INNER JOIN `{$this->db->dbprefix}layer` l ON a2l.layer_id=l.id
                INNER JOIN `{$this->db->dbprefix}factor` f ON f.id = l.factor_id
                WHERE f.study_id={$study_id}";
        $this->db->query($sql,array($id));
        //echo($this->db->last_query());
        //echo("\nlines: ".$this->db->affected_rows()."\n\n");

        $sql="delete l FROM `{$this->db->dbprefix}layer` l
                INNER JOIN `{$this->db->dbprefix}factor` f ON f.id = l.factor_id
                WHERE f.study_id={$study_id}";
        $this->db->query($sql,array($id));
        //echo($this->db->last_query());
        //echo("\nlines: ".$this->db->affected_rows()."\n\n");

        $this->db->delete('factor',array('study_id'=>$study_id));
        //echo($this->db->last_query());
        //echo("\nlines: ".$this->db->affected_rows()."\n\n");

        $this->db->delete('study',array('id'=>$study_id));
        //echo($this->db->last_query());
        //echo("\nlines: ".$this->db->affected_rows()."\n\n");

        $sql="delete a FROM `{$this->db->dbprefix}allocation` a
                INNER JOIN `{$this->db->dbprefix}group` g ON g.id = a.group_id
                WHERE g.study_id={$study_id}";
        $this->db->query($sql,array($id));
        //echo($this->db->last_query());
        //echo("\nlines: ".$this->db->affected_rows()."\n\n");

        $this->db->delete('group',array('study_id'=>$study_id));
        //echo($this->db->last_query());
        //echo("\nlines: ".$this->db->affected_rows()."\n\n");

        $this->db->trans_complete();
        //echo "<a href='".site_url('study')."'>go back to studies</a>";
        redirect('study/');
    }


    public function group(){
        $study_id=$this->input->get('study_id');
        $in_add_guide=$this->input->get('in_add_guide');
        //检测所有权限
        $this->load->model('study_model');
        $study=$this->study_model->get($study_id);
        if($study['owner_uid'] != $this->operate_user_id){
            redirect('study/');
        }
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
        $data['in_add_guide']=$in_add_guide;
        $data['form_action']=site_url('study/group_save');

        $data['links']['edit']=site_url("/study/edit/".$study_id);
        $data['links']['detail_link']=site_url("/study/".$study_id);
        $data['links']['factors']=site_url("factor/?study_id=".$study_id);
        $data['links']['view']=site_url("/study/");
        $data['links']['add']=site_url("/study/add");
        $data['links']['factor_add']=site_url('factor/add?study_id='.$study_id);
        $data['links']['groups_edit_link']=site_url("/study/group?study_id=".$study_id);

        $data=array_merge($this->data,$data);
        $this->load->view('study/group',$data);
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
                    if($groups[$row['group_id']]){
                        $this->db->where('id',$row['group_id'])
                             ->update('group',array(
                                    'name'=>$groups[$row['group_id']]
                                    ));
                    }else{
                        //TODO:这里的功能没有测试
                        $this->db->delete('group',array('id'=>$row['group_id']));
                        //删除相关group的记录: a2l,a两表
                        $sql="delete a2l from {$this->db->dbprefix}allocation2layer a2l
                              inner join {$this->db->dbprefix}allocation a on a2l.allocation_id=a.id
                              where a.group_id={$row['group_id']}";
                        $this->db->query($sql);
                        $this->db->delete('allocation',array('group_id'=>$row['group_id']));
                    }
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
        if($this->input->post('in_add_guide')==1){
            redirect('factor/?study_id='.$study_id);
        }else{
            redirect('study/'.$study_id);
        }
    }

}
