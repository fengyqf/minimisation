<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
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

        $lang=$this->input->cookie('lang',TRUE);
        $this->lang->load('common',$lang);

        $this->data['bootstrap']=$this->load->view('part/bootstrap', NULL, true);
        $this->data['site_name']=lang('site_name');
    }


	public function index()
	{
		//set language
		if($lang=$this->input->get('lang')){
			if(strlen($lang)<20){
				$cookie=array('name'=>'lang',
					'value'=>$lang,
					'expire'=>'864000',
					'path'=>'/',
					);
				$this->input->set_cookie($cookie);
			}
	        $this->lang->load('common',$lang);
		}
		$data=array();
        $data=array_merge($this->data,$data);
		$this->load->view('welcome_message',$data);
	}
}
