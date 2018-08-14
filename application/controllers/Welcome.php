<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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

        $lang=$this->input->cookie('lang',TRUE);
        $this->lang->load('common',$lang);

        $this->data['bootstrap']=$this->load->view('part/bootstrap', NULL, true);
        $this->data['site_name']=lang('site_name');
    }


	public function index()
	{
        $this->load->library('session');
        $this->operate_user_id=(int)$this->session->userdata('user_id');
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
        $data['user_id']=$this->operate_user_id;
        $data=array_merge($this->data,$data);
		$this->load->view('welcome_message',$data);
	}


    public function login()
    {
        $this->load->library('session');
        $data=array();
        $data=array_merge($this->data,$data);
        $this->load->view('login',$data);
    }

    public function auth()
    {

        $username=$this->input->post('name',TRUE);
        $password=$this->input->post('pass',TRUE);
        if(!$password or !$username){
            $this->login();
            return;
        }
        $this->load->database('default');
        $this->db
            ->select('id')
            ->from('user')
            ->where('name',$username)
            ->where('pass',$password);
        $query=$this->db->get();
        if ($query->num_rows() > 0){
            $row = $query->row_array();
            $this->load->library('session');
            $this->session->set_userdata('user_id',$row['id']);
            $data=array();
            $data=array_merge($this->data,$data);
            #$this->load->view('welcome_message',$data);
            redirect('/welcome');
        }else{
            $this->login();
            return;
        }
    }

    public function logout(){
        $this->load->library('session');
        $this->session->sess_destroy();

        $data=array();
        $data=array_merge($this->data,$data);
        $this->load->view('login',$data);
    }

}
