<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Factor extends CI_Controller {

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

        //当前操作的用户，用户id号的逻辑在 mnmssession_model 实现
        $this->load->model('mnmssession_model');
        $this->mnmssession_model->init();
        $this->operate_user_id=$this->mnmssession_model->operate_user_id;

        $this->load->database('default');

        $lang=$this->input->cookie('lang',TRUE);
        $this->lang->load('common',$lang);

        $this->data['bootstrap']=$this->load->view('part/bootstrap', NULL, true);
        $this->data['site_name']=lang('site_name');
    }


    public function index(){
        $study_id=(int)($this->input->get('study_id'));
        //检测当前操作用户是否有操作study_id的权限
        $this->load->model('study_model');
        $this->study=$this->study_model->get($study_id);

        if(!$this->study or $this->study['owner_uid']!=$this->operate_user_id){
            redirect('study/');
        }else{
            $study_name=$this->study['name'];
        }

        $this->load->model('factor_model');
        $factors=$this->factor_model->get(array('study_id'=>$study_id));

        $study=$this->study;
        //var_dump($study);
        //var_dump($factors);
        if($study['owner_uid']!=$this->operate_user_id){
            redirect('study/');
        }
        $data=array();
        $data['study']=$study;
        $data['factors']=$factors;
        $data['form_add_action']=site_url('factor/add_do?study_id='.$study_id);
        $data['form_edit_action']=site_url('factor/add_do?study_id='.$study_id);
        $data['links']['edit']=site_url("/study/edit/".$study_id);
        $data['links']['detail_link']=site_url("/study/".$study_id);
        $data['links']['factors']=site_url("factor/?study_id=".$study_id);
        $data['links']['view']=site_url("/study/");
        $data['links']['add']=site_url("/study/add");
        $data['links']['factor_add']=site_url('factor/add?study_id='.$study_id);
        $data['links']['groups_edit_link']=site_url("/study/group?study_id=".$study_id);
        $data=array_merge($this->data,$data);
        $this->load->view('factor/view',$data);
    }


    public function edit($id=NULL){
        $id=(int)$id;
        $this->db
             ->select('f.id as factor_id,f.name as factor_name,f.weight,f.study_id')
             ->from('factor f')
             ->join('study s','f.study_id=s.id','inner')
             ->where('f.id',$id)
             ->where('s.owner_uid',$this->operate_user_id)
             ->limit(1);
        $query=$this->db->get();
        if($factor=$query->row_array()){
            //加载当前study基础数据
            $factor['weight']=$factor['weight']/100;
            $study_id=$factor['study_id'];
            $this->load->model('study_model');
            $study=$this->study_model->get($study_id);
            $data['factor']=$factor;
            $data['study']=$study;
            $data['form_action']=site_url('factor/edit_save');
            $data['links']['edit']=site_url("/study/edit/".$study_id);
            $data['links']['detail_link']=site_url("/study/".$study_id);
            $data['links']['factors']=site_url("factor/?study_id=".$study_id);
            $data['links']['view']=site_url("/study/");
            $data['links']['add']=site_url("/study/add");
            $data['links']['factor_add']=site_url('factor/add?study_id='.$study_id);
            $data['links']['groups_edit_link']=site_url("/study/group?study_id=".$study_id);
            $data=array_merge($this->data,$data);
            $this->load->view('factor/edit',$data);
        }else{
            //redirect('study/');
        }
    }


    public function add_do(){
        $study_id=(int)($this->input->get_post('study_id'));
        //检测当前操作用户是否有操作study_id的权限
        $this->load->model('study_model');
        $this->study=$this->study_model->get($study_id);
        if(!$this->study or $this->study['owner_uid']!=$this->operate_user_id){
            redirect('study/');
        }else{
            $name=$this->input->post('name');
            $weight=$this->input->post('weight');
            if(!$name){
                $name=lang('new_factor_default_name');
            }
            if(!$weight){
                $weight=(int)($this->config->item('factor_default_weight') * 100);
            }else{
                $weight=(int)($weight * 100);
            }
            $this->db->insert('factor',array(
                'study_id'=>$study_id,
                'name'=>$name,
                'weight'=>$weight,
                ));
            $factor_id=$this->db->insert_id();
            redirect('factor/layer?factor_id='.$factor_id);
        }

    }


    public function edit_save(){
        $id=(int)($this->input->get_post('id'));
        $name=$this->input->post('name');
        $weight=$this->input->post('weight');
        $study_id=0;
        if(!$name){
            $name=lang('new_factor_default_name');
        }
        if(!$weight){
            $weight=(int)($this->config->item('factor_default_weight') * 100);
        }else{
            $weight=(int)($weight * 100);
        }
        $this->db
             ->select('f.id as factor_id,f.name as factor_name,f.weight,f.study_id')
             ->from('factor f')
             ->join('study s','f.study_id=s.id','inner')
             ->where('f.id',$id)
             ->where('s.owner_uid',$this->operate_user_id)
             ->limit(1);
        $query=$this->db->get();
        if($factor=$query->row_array()){
            $study_id=$factor['study_id'];
            $this->db->where('id',$id)
                     ->update('factor'
                        ,array(
                            'name'=>$name,
                            'weight'=>$weight,
                        ));
        }
        redirect('factor/?study_id='.$study_id);
    }


    public function del($id=NULL){
        $id=(int)$id;
        $study_id=0;
        $this->db
             ->select('f.id as factor_id,f.name as factor_name,f.weight,f.study_id')
             ->from('factor f')
             ->join('study s','f.study_id=s.id','inner')
             ->where('f.id',$id)
             ->where('s.owner_uid',$this->operate_user_id)
             ->limit(1);
        $query=$this->db->get();
        if($factor=$query->row_array()){
            $study_id=$factor['study_id'];
            //删除layer,a2l,factor 三表中相应数据
            //$this->db->trans_begin();     //test when debug
            $this->db->trans_start();
            $sql="delete a2l FROM `{$this->db->dbprefix}allocation2layer` a2l
                 inner join `{$this->db->dbprefix}layer` l on a2l.layer_id=l.id WHERE l.factor_id=?";
            $this->db->query($sql,array($id));
            //var_dump($this->db->last_query());
            $this->db->delete('layer',array('factor_id'=>$id));
            //var_dump($this->db->last_query());
            $this->db->delete('factor',array('id'=>$id));
            //var_dump($this->db->last_query());
            //$this->db->trans_rollback();     //test when debug
            $this->db->trans_complete();
        }
        redirect('factor/?study_id='.$study_id);
    }


    public function layer(){
        $factor_id=(int)($this->input->get_post('factor_id'));
        $this->db->select('l.id as layer_id,l.name as layer_name')
                 ->from('layer l')
                 ->join('factor f','l.factor_id=f.id','inner')
                 ->where('f.id',$factor_id)
                 ->limit(100);      //假定最大500条
        $query=$this->db->get();
        $layers=array();
        foreach ($query->result_array() as $row) {
            $layers[]=$row;
        }
        //检查所有权
        $this->db->select('s.id,s.name,f.name as factor_name')
                 ->from('factor f')
                 ->join('study s','f.study_id=s.id','inner')
                 ->where('f.id',$factor_id)
                 ->where('s.owner_uid',$this->operate_user_id)
                 ->limit(1);
        $query=$this->db->get();
        if($row=$query->row_array()){
            $study_id=$row['id'];
            $data['study']=$row;
            $data['factor']=array('id'=>$factor_id,'name'=>$row['factor_name']);
            $data['layers']=$layers;
            $data['factor_id']=$factor_id;
            $data['form_action']=site_url('factor/layer_save');
            $data['links']['edit']=site_url("study/edit/".$study_id);
            $data['links']['detail_link']=site_url("/study/".$study_id);
            $data['links']['factors']=site_url("factor/?study_id=".$study_id);
            $data['links']['view']=site_url("/study/");
            $data['links']['add']=site_url("/study/add");
            $data['links']['factor_add']=site_url('factor/add?study_id='.$study_id);
            $data['links']['groups_edit_link']=site_url("/study/group?study_id=".$study_id);
            $data=array_merge($this->data,$data);
            $this->load->view('factor/layer',$data);
        }else{
            redirect('study/');
        }
    }



    public function layer_save(){
        $factor_id=$this->input->post('factor_id');
        $layers=$this->input->post('layers');
        $layer_new=$this->input->post('layer_new');
        //计算study_id，并检测权限
        $this->load->model('factor_model');
        $study=$this->factor_model->get_study(array('factor_id'=>$factor_id));
        if(!$study){
            redirect('study/');
        }else{
            $study_id=isset($study['id']) ? $study['id'] : 0;
            $owner_uid=isset($study['owner_uid']) ? (int)$study['owner_uid'] : 0;
            if(!$study_id or $owner_uid!=$this->operate_user_id){
                redirect('study/');
            }
        }
        //修改部分$layers
        if(count($layers)>=1){
            $this->db
                 ->select('l.id as layer_id,l.name as layer_name')
                 ->from('layer l')
                 ->join('factor f','f.id=l.factor_id','inner')
                 ->join('study s','s.id=f.study_id','inner')
                 ->where('s.owner_uid',$this->operate_user_id)
                 ->where_in('l.id',array_keys($layers))
                 ->order_by('l.id','asc');
            $query=$this->db->get();
            //var_dump($this->db->last_query());
            foreach($query->result_array() as $row ){
                //按上面带权限限定的查询结果，更新相应layer_id对应的数据，
                //  更新为POST['layers']中对应值，事实上仅layer.name
                if(isset($layers[$row['layer_id']])){
                    if($layers[$row['layer_id']]){
                        $this->db->where('id',$row['layer_id'])
                             ->update('layer',array(
                                    'name'=>$layers[$row['layer_id']]
                                    ));
                    }else{
                        $this->db->trans_start();
                        //删除相关layer的记录: a2l,l两表
                        $this->db->delete('allocation2layer',array('layer_id'=>$row['layer_id']));
                        //var_dump($this->db->last_query());
                        $this->db->delete('layer',array('id'=>$row['layer_id']));
                        //var_dump($this->db->last_query());
                        $this->db->trans_complete();
                    }
                    //var_dump($layers,$layer_new);
                }
            }
        }
        //新添加部分$layer_new
        if($layer_new){
            $data=array();
            foreach ($layer_new as $item) {
                if($item){
                    $data[]=array('name'=>$item,'factor_id'=>$factor_id);
                }
            }
            if($data){
                $this->db->insert_batch('layer',$data);
            }
        }
        redirect('factor/?study_id='.$study_id);

    }




}
