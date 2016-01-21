<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Allocation extends CI_Controller {

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
        $this->lang->load('common');

        $this->data['bootstrap']=$this->load->view('part/bootstrap', NULL, true);
        $this->data['site_name']=$this->config->item('site_name');
    }


    public function index(){
        $study_id=(int)($this->input->get('study_id'));
        //检测权限
        $this->load->model('study_model');
        $study=$this->study_model->get($study_id);
        if($this->operate_user_id!=$study['owner_uid']){
            redirect('study/');
        }
        $rs_count=$this->study_model->get_allocation_count($study_id);

        $this->db
            ->select('id,name')
            ->from('group')
            ->where('study_id',$study_id);
        $query=$this->db->get();
        $groups=array();
        foreach ($query->result_array() as $row) {
            $groups[$row['id']]=array('group_id'=>$row['id'],'group_name'=>$row['name']);
        }
        //var_dump($groups);

        $this->load->model('factor_model');
        $factors=$this->factor_model->get(array('study_id'=>$study_id),TRUE);
        foreach ($factors as $key => $value) {
            unset($factors[$key]['layers_link']);
            unset($factors[$key]['del_link']);
            unset($factors[$key]['edit_link']);
        }
        //var_dump($factors);
        //die();

        $study['groups_link']=site_url('study/group?study_id='.$study['id']);
        $study['factors_link']=site_url('factor/?study_id='.$study['id']);
        $study['layers_link']=site_url('layer/?study_id='.$study['id']);
        $study['detail_link']=site_url('study/'.$study['id']);
        $study['edit_link']=site_url('study/edit/'.$study['id']);
        $study['allocations_link']=site_url('allocation/?study_id='.$study['id']);
        $study['allocation_add_link']=site_url('allocation/add?study_id='.$study['id']);
        $study['allocation_history_link']=site_url('allocation/history?study_id='.$study['id']);
        $data['study']=$study;
        $data['factors']=$factors;
        $data['groups']=$groups;
        $data['rs_count']=$rs_count;
        $data['links']['edit']=site_url("/study/edit/".$study_id);
        $data['links']['detail_link']=site_url("/study/".$study_id);
        $data['links']['factors']=site_url("factor/?study_id=".$study_id);
        $data['links']['view']=site_url("/study/");
        $data['links']['add']=site_url("/study/add");
        $data['links']['factor_add']=site_url('factor/add?study_id='.$study_id);
        $data['links']['groups_edit_link']=site_url("/study/group?study_id=".$study_id);
        $data=array_merge($this->data,$data);
        $this->load->view('allocation/view',$data);
    }


    public function add(){
        $study_id=(int)($this->input->get('study_id'));
        $flash=$this->input->get('flash');      //flash消息
        //$study_id=2001;    //当前研究课题，测试阶段写死调试
        //检测权限
        $this->load->model('study_model');
        $study=$this->study_model->get($study_id);
        if($this->operate_user_id!=$study['owner_uid']){
            redirect('study/');
        }
        //当前study的factor, layer, 并归并存储到factor数组中
        $factors=array();
        $this->db->select('id,name')
                 ->from('factor')
                 ->where('study_id',$study_id);
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $factors[$row['id']]=array(
                'factor_id' => $row['id'],
                'factor_name' => $row['name'],
                'layers' => array(),
                );
        }

        $this->db->select('f.id as factor_id,f.name as factor_name,f.study_id,l.id as layer_id, l.name as layer_name')
                 ->from('factor f')
                 ->join('layer l','f.id=l.factor_id','inner')
                 ->where('f.study_id',$study_id);
        $query=$this->db->get();
        //var_dump($this->db->last_query());
        foreach($query->result_array() as $row){
            $factors[$row['factor_id']]['layers'][]=array(
                'layer_id'=>$row['layer_id'],
                'layer_name'=>$row['layer_name']
                );
        }
        //var_dump($factors);
        //检测factor及layer的完整性，不完整则显示flash消息
        if(count($factors)<2){
            if($flash){
                $flash.='<br>'.lang('mesg_factors_not_enough');
            }else{
                $flash=lang('mesg_factors_not_enough');
            }
        }
        foreach ($factors as $factor) {
            if(!isset($factor['layers']) or count($factor['layers'])<2){
                $mesg=sprintf(lang('mesg_layers_not_enough_in_%s'),$factor['factor_name']);
                 if($flash){
                    $flash.='<br>'.$mesg;
                }else{
                    $flash=$mesg;
                }
            }
        }


        $study['groups_link']=site_url('study/group?study_id='.$study['id']);
        $study['factors_link']=site_url('factor/?study_id='.$study['id']);
        $study['layers_link']=site_url('layer/?study_id='.$study['id']);
        $study['detail_link']=site_url('study/'.$study['id']);
        $study['edit_link']=site_url('study/edit/'.$study['id']);
        $study['allocations_link']=site_url('allocation/?study_id='.$study['id']);
        $study['allocation_add_link']=site_url('allocation/add?study_id='.$study['id']);
        $study['allocation_history_link']=site_url('allocation/history?study_id='.$study['id']);
        $data['study']=$study;
        $data['links']['edit']=site_url("/study/edit/".$study_id);
        $data['links']['detail_link']=site_url("/study/".$study_id);
        $data['links']['factors']=site_url("factor/?study_id=".$study_id);
        $data['links']['view']=site_url("/study/");
        $data['links']['add']=site_url("/study/add");
        $data['links']['factor_add']=site_url('factor/add?study_id='.$study_id);
        $data['links']['groups_edit_link']=site_url("/study/group?study_id=".$study_id);
        $data['form_action']=site_url("/allocation/add_do");
        $data['study_id']=$study_id;
        $data['factors']=$factors;
        $data['flash']=$flash;
        $data=array_merge($this->data,$data);
        $this->load->view('allocation/add',$data);
    }


    public function add_do(){
        $study_id=(int)($this->input->post('study_id'));
        $allocation_name=$this->input->post('name');
        if(!$allocation_name){
            date_default_timezone_set('Asia/Shanghai');
            $allocation_name='Anonymous ('.date('YmdHis').')';
        }
        $factors=$this->input->post('factors');
        //检测当前操作用户是否有操作study_id的权限
        $this->load->model('study_model');
        $study=$this->study_model->get($study_id);
        if($this->operate_user_id!=$study['owner_uid']){
            redirect('study/');
        }else{
            $study_name=$study['name'];
            $study_group_count=$study['group_count'];
            $study_owner_uid=$study['owner_uid'];
            $study_bias=(int)$study['bias'];     //1-100的整数
            $study_factor_count=(int)$this->study_model->get_factor_count($study_id);
        }
        if( !is_array($factors) or count($factors) < $study_factor_count){
            redirect('allocation/add?study_id='.$study_id.'&flash='.lang('text_allocation_add_factor_count_error_notice'));
        }

        $this->db
            ->select('id,name')
            ->from('group')
            ->where('study_id',$study_id);
        $query=$this->db->get();
        $groups=array();
        foreach ($query->result_array() as $row) {
            $groups[$row['id']]=array('group_id'=>$row['id'],'group_name'=>$row['name']);
        }
        if(!$groups){
            redirect('study/group?study_id='.$study_id);
        }

        $data_layers=array();
        $this->db->select('l.id as layer_id,l.name as layer_name,f.id as factor_id,f.name as factor_name,f.weight as factor_weight')
                 ->from('layer l')
                 ->join('factor f','f.id=l.factor_id','inner')
                 ->where('f.study_id',$study_id)
                 ->order_by('f.id','asc')
                 ->order_by('l.id','asc');
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $data_layers[$row['layer_id']]=array(
                'layer_id' => $row['layer_id'],
                'layer_name' => $row['layer_name'],
                'factor_id' => $row['factor_id'],
                'factor_name' => $row['factor_name'],
                'factor_weight' => $row['factor_weight'],
                );
        }
        //$this->dump_gl($data_layers,20);

        $this->db->select('p.group_id,p2l.`layer_id`,count(p2l.`allocation_id`) as cnt')
                 ->from('allocation2layer p2l')
                 ->join('layer l','l.id=p2l.layer_id','inner')
                 ->join('factor f','f.id=l.factor_id','inner')
                 ->join('allocation p','p.id=p2l.allocation_id')
                 ->where('f.study_id',$study_id)
                 ->where_in('p2l.layer_id',$factors)
                 ->group_by(array('p.group_id','p2l.`layer_id`'));
        $query=$this->db->get();
        //var_dump($this->db->last_query());
        /* 二维阵列
        */
        $gl_cnt=array();        //存储各相关因素(层级)的计数的二维阵列
        $sd_test=array();
        //var_dump($groups);
        foreach($groups as $group){
            foreach ($factors as $factor_id => $layer_id) {
                $gl_cnt[$group['group_id']][$layer_id]=0;
                $sd_test[$group['group_id']][$layer_id]=0;
            }
        }
        //var_dump($gl_cnt);
        foreach($query->result_array() as $row){
            //var_dump($row);
            $gl_cnt[$row['group_id']][$row['layer_id']]=(int)$row['cnt'];
        }
        /*
        echo "\n------- origin gl_cnt start -------------\n";
        $this->dump_gl($gl_cnt);
        */

        foreach($groups as $group){
            foreach ($factors as $factor_id => $layer_id) {
                $tmp=$gl_cnt;
                $tmp[$group['group_id']][$layer_id]+=1;
                //$this->dump_gl($tmp);
                //var_dump($tmp[$group['group_id']]);
                $sd_test[$group['group_id']][$layer_id]=$this->stats_standard_deviation($tmp[$group['group_id']]);
            }
        }

        //echo("\n------gl_cnt---------\n");
        //echo $this->dump_gl($gl_cnt);

        //echo("\n------sd_test---------\n");
        //echo $this->dump_gl($sd_test,20);

        $group_sum_sd=array();  //各组的sd加权和
        foreach ($sd_test as $group_id => $line) {
            $group_sum_sd[$group_id]=0;
            foreach ($line as $layer_id => $sd) {
                if(isset($data_layers[$layer_id]['factor_weight'])){
                    $weight=$data_layers[$layer_id]['factor_weight'];
                    //TODO 严格起见，这里有必要判断一下weight的值是否为0，对于为0给出警报
                }else{
                    //严重错误（算法缺陷）：指定的layer不存在；需要调试并改进算法
                    //die('Error! 算法缺陷');
                    redirect('allocation/add?study_id='.$study_id.'&flash='.lang('text_allocation_add_factor_to_layer_error_notice'));
                }
                $group_sum_sd[$group_id]+=$weight*$sd;
            }
        }
        //var_dump($group_sum_sd);
        //$group_sum_sd_original=$group_sum_sd;

        //$aim_group_id=NULL;目标组编号
        asort($group_sum_sd);
        reset($group_sum_sd);
        $gs_m=each($group_sum_sd);  //group sum sd中最小值minimal
        $gs_n=each($group_sum_sd);  //group sum sd中次小值next
        //var_dump($gs_m,$gs_n);
        if(!$gs_n){
            //项目只定义了一个group
            $aim_group_id=$gs_m['key'];
        }elseif($gs_m['value']==$gs_n['value']){
            //随机分配到所有最小值的组中
            //探测所有与$gs_m['value']相同的值, 将key存储到$minimal_keys[]中
            $minimal_keys[]=$gs_m['key'];
            $minimal_keys[]=$gs_n['key'];
            while($gs_test=each($group_sum_sd)){
                if($gs_test['value']==$gs_m['value']){
                    $minimal_keys[]=$gs_test['key'];
                }
            }
            $rand_seed=rand(0,count($minimal_keys)-1);
            $aim_group_id=$minimal_keys[$rand_seed];
        }elseif($gs_m < $gs_n){
            while(1){
                asort($group_sum_sd);
                reset($group_sum_sd);
                $gs_m=each($group_sum_sd);  //group sum sd中最小值minimal
                $gs_n=each($group_sum_sd);  //group sum sd中次小值next
                //var_dump($gs_m,$gs_n);
                $rand_seed=rand(1,100);
                if($rand_seed<$study_bias or !each($group_sum_sd) ){
                    $aim_group_id=$gs_m['key'];
                    break;
                }else{
                    //4th param($preserve_keys): require php 5.0.2
                    $group_sum_sd=array_slice($group_sum_sd,1,NULL,true);
                }
            }
        }else{
            //正常情况下，绝对不会到这里
            die('Error: 严重错误（算法有误）A');
        }

        if(!isset($aim_group_id)){
            die('Error: 严重错误（算法有误）B');
        }
        //结果
        //echo "<br>\n\n<br>aim_group_id: ".$aim_group_id;

        //数据入库
        $this->db->trans_start();
        $data=array('name'=>$allocation_name,
                    'group_id'=>$aim_group_id,
                    'time'=>time(),
            );
        $this->db->insert('allocation',$data);
        $new_allocation_id=$this->db->insert_id();
        $data=array();
        foreach ($factors as $factor_id => $layer_id) {
            $data[]=array('allocation_id'=>$new_allocation_id,
                      'layer_id'=>$layer_id,
                );
        }
        $this->db->insert_batch('allocation2layer',$data);

        $this->db->trans_complete();

        //输出一个简短报告：每个因素水平、目标组，及一些链接
        $data=array();
        //var_dump($factors);
        foreach ($factors as $factor) {
            $data['factors'][]=array(
                    'factor_name'=>$data_layers[$factor]['factor_name'],
                    'factor_id'=>$data_layers[$factor]['factor_id'],
                    'layer_id'=>$data_layers[$factor]['layer_id'],
                    'layer_name'=>$data_layers[$factor]['layer_name'],
                    );
        }
        $data['aim_group']=array(
                'group_id'=>$aim_group_id,
                'group_name'=>isset($groups[$aim_group_id]['group_name']) ? $groups[$aim_group_id]['group_name'] : 'Error: 算法错误group_name',
                );

        $data['study']=$study;
        $data['links']['edit']=site_url("/study/edit/".$study_id);
        $data['links']['detail_link']=site_url("/study/".$study_id);
        $data['links']['factors']=site_url("factor/?study_id=".$study_id);
        $data['links']['view']=site_url("/study/");
        $data['links']['add']=site_url("/study/add");
        $data['links']['factor_add']=site_url('factor/add?study_id='.$study_id);
        $data['links']['groups_edit_link']=site_url("/study/group?study_id=".$study_id);

        $data['link']['add_new']=site_url('/allocation/add?study_id='.$study_id);
        $data['link']['correct']=site_url('/allocation/correct/'.$new_allocation_id);
        $data['link']['view']=site_url('/allocation');
        //var_dump($data);

        $data=array_merge($this->data,$data);
        $this->load->view('allocation/add_done',$data);
    }


    public function correct($allocation_id){
        $allocation_id=(int)$allocation_id;
        //检查 $allocation_id对应的study是否是当前用户所有
        $study_id=0;
        $this->db->select('s.id as study_id,s.owner_uid')
                 ->from('allocation2layer p2l')
                 ->join('layer l','l.id=p2l.layer_id','inner')
                 ->join('factor f','f.id=l.factor_id','inner')
                 ->join('study s','s.id=f.study_id','inner')
                 ->where('p2l.allocation_id',$allocation_id)
                 ->where('s.owner_uid',$this->operate_user_id)
                 ->limit(1);
        $query=$this->db->get();
        if($row=$query->row_array()){
            $study_id=$row['study_id'];
            //有相应记录，检查通过，做清理操作: p,p2l 两表
            $this->db->delete('allocation',array(
                    'id'=>$allocation_id
                ));
            //var_dump($this->db->last_query());
            $this->db->delete('allocation2layer',array(
                    'allocation_id'=>$allocation_id
                ));
            //var_dump($this->db->last_query());
            $flash=lang('allocation_correct_notice');
            redirect('allocation/add?study_id='.$study_id.'&flash='.$flash);
        }else{
            redirect('study/');
        }
    }


    public function history(){
        $study_id=(int)($this->input->get('study_id'));
        $page=(int)($this->input->get('page'));
        $pagesize=$this->config->item('allocation_history_pagesize');
        //echo "\n\n$pagesize\n\n\n";
        if($page<=0){
            $page=1;
        }
        $this->load->model('study_model');
        $study=$this->study_model->get($study_id);
        if(!isset($study['owner_uid']) or $study['owner_uid']!=$this->operate_user_id){
            redirect('study/');
        }
        $rs_count=$this->study_model->get_allocation_count($study_id);
        $groups=array();
        $this->db->select('id,name')
                 ->from('group')
                 ->where('study_id',$study_id)
                 ->order_by('id','asc');
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $groups[$row['id']]=array('group_id'=>$row['id'],'group_name'=>$row['name']);
        }
        //var_dump($groups);

        $factors=array();
        $this->db->select('id as factor_id,name as factor_name')
                 ->from('factor')
                 ->where('study_id',$study_id)
                 ->order_by('id','asc');
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $factors[]=$row;
        }
        //var_dump($factors);
        //用于构造输出数据中的默认值: factor_id => allocation_layer_name
        $def_factor_arr=array();
        foreach ($factors as $factor) {
            $def_factor_arr[$factor['factor_id']]='';
        }

        $fl_data=array();
        /*
        //factor-layer data, 本study项目中的所有
        $this->db->select('f.id as factor_id,f.name as factor_name,l.id as layer_id,l.name as layer_name')
                 ->from('factor f')
                 ->join('layer l','l.factor_id=f.id','inner')
                 ->where('f.study_id',$study_id);
        $query=$this->db->get();
        foreach ($query->result_array() as $row) {
            $fl_data[$row['layer_id']]=$row;
            $fl_data[$row['layer_id']]['factors']=$def_factor_arr;
        }
        //var_dump($this->db->last_query());
        //var_dump($fl_data);
        */


        $allocations=array();
        //按分页读取相应的allocation记录，然后逐条记录 按该study的factor增加相应layer数据
        $this->db->select('id,name,from_unixtime(time) as time,group_id')
                 ->from('allocation')
                 ->where_in('group_id', $groups ? array_keys($groups) : 0)
                 ->order_by('id','desc');
        //$this->db->limit($pagesize,($page-1)*$pagesize);
        if($page > 1 ){
            $this->db->limit($pagesize, ($page-1)*$pagesize);
        }else{
            $this->db->limit($pagesize);
        }
        $query=$this->db->get();
        //var_dump($this->db->last_query());
        foreach ($query->result_array() as $row) {
            $row['group_name']=isset($groups[$row['group_id']]) ? $groups[$row['group_id']]['group_name'] : lang('unknown_group');
            $allocations[$row['id']]=$row;
        }
        //var_dump($allocations);
        $a2l=array();
        if($allocations){
            $this->db->select('a2l.`allocation_id`,f.id AS factor_id,f.name AS factor_name,a2l.`layer_id`,l.name AS layer_name')
                     ->from('allocation2layer a2l')
                     ->join('layer l','l.id = a2l.layer_id','join')
                     ->join('factor f','f.id = l.factor_id')
                     ->where('f.study_id',$study_id)
                     ->where_in('a2l.allocation_id',array_keys($allocations))
                     ->order_by('a2l.id','asc');
            $query=$this->db->get();
            foreach ($query->result_array() as $row) {
                $a2l[]=$row;
            }
            //var_dump($this->db->last_query());
            //var_dump($a2l);
        }

        $empty_factor_allocation_exists=0;
        foreach ($allocations as $key => $allocation) {
            //计算每个allocation在各个factor上分配的layer_name，从fl_data中
            foreach ($factors as $factor) {
                //factor
                $tmp_layer_name='';
                $found=0;
                foreach($a2l as $item){
                    if($item['factor_id']==$factor['factor_id'] && $allocation['id']==$item['allocation_id']){
                        $tmp_layer_name=$item['layer_name'];
                        $found=1;
                        break;
                    }
                }
                if($found){
                    $allocations[$key]['factors'][$factor['factor_id']]= $tmp_layer_name ;
                }else{
                    $empty_factor_allocation_exists++;
                }

            }
        }
        //echo "\n\n\n";
        //var_dump($allocations);

        $this->load->library('pagination');
        $page_config['base_url'] = site_url('allocation/history?study_id='.$study_id.'');
        $page_config['total_rows'] = $rs_count;
        $page_config['per_page'] = $pagesize;
        $page_config['use_page_numbers']=TRUE;
        $page_config['enable_query_strings'] = TRUE;
        $page_config['page_query_string'] = TRUE;
        $page_config['query_string_segment']='page';
        $page_config['first_link'] = '&laquo;';
        $page_config['last_link'] = '&raquo;';
        $this->pagination->initialize($page_config); 

        $pagebar= $this->pagination->create_links();

        $study['allocations_link']=site_url('allocation/?study_id='.$study['id']);
        $study['allocation_add_link']=site_url('allocation/add?study_id='.$study['id']);
        $study['allocation_history_link']=site_url('allocation/history?study_id='.$study['id']);
        $data['study']=$study;
        $data['factors']=$factors;
        $data['allocations']=$allocations;
        $data['empty_factor_allocation_exists']=$empty_factor_allocation_exists;
        $data['links']['edit']=site_url("/study/edit/".$study_id);
        $data['links']['detail_link']=site_url("/study/".$study_id);
        $data['links']['factors']=site_url("factor/?study_id=".$study_id);
        $data['links']['view']=site_url("/study/");
        $data['links']['add']=site_url("/study/add");
        $data['links']['factor_add']=site_url('factor/add?study_id='.$study_id);
        $data['links']['groups_edit_link']=site_url("/study/group?study_id=".$study_id);

        $data['link']['add_new']=site_url('/allocation/add?study_id='.$study_id);
        $data['link']['view']=site_url('/allocation');
        $data['pagebar']=$pagebar;
        $data['pagesize']=$pagesize;
        $data['rs_count']=$rs_count;
        $data=array_merge($this->data,$data);
        $this->load->view('allocation/history',$data);
    }


    private function find_allocation(){
        //
    }


    private function dump_gl($gl_cnt,$width=10){
        $buff="\n<pre>\n";
        foreach ($gl_cnt as $line_head => $line) {
            $buff .= sprintf('%'.$width.'s','H').'|';
            foreach ($line as $key => $value) {
                $buff .= sprintf('%'.$width.'s',$key);
            }
            $fields_count=count($line);
            break;
        }
        $line_2=str_repeat('-', $width).'|'.str_repeat('-', ($width+1)*$fields_count)."\n";    //分隔行
        $buff .= "\n".$line_2;

        foreach ($gl_cnt as $line_head => $line) {
            $buff .= sprintf('%'.$width.'s',$line_head).'|';
            foreach ($line as $field => $value) {
                $buff.=sprintf('%'.$width.'s',$value);
            }
            $buff.="\n";
        }
        $buff.="\n</pre>\n";
        echo($buff);
    }


     /**
      * This user-land implementation follows the implementation quite strictly;
      * it does not attempt to improve the code or algorithm in any way. It will
      * raise a warning if you have fewer than 2 values in your array, just like
      * the extension does (although as an E_USER_WARNING, not E_WARNING).
      * 
      * @param array $a 
      * @param bool $sample [optional] Defaults to false
      * @return float|bool The standard deviation or false on error.
      */
    private function stats_standard_deviation(array $a, $sample = false) {
         $n = count($a);
         if ($n === 0) {
             trigger_error("The array has zero elements", E_USER_WARNING);
             return false;
         }
         if ($sample && $n === 1) {
             trigger_error("The array has only 1 element", E_USER_WARNING);
             return false;
         }
         $mean = array_sum($a) / $n;
         $carry = 0.0;
         foreach ($a as $val) {
             $d = ((double) $val) - $mean;
             $carry += $d * $d;
         };
         if ($sample) {
            --$n;
         }
         return sqrt($carry / $n);
    }



}
