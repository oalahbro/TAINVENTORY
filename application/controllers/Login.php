<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->model('mymodel');
	}

	public function index()
	{
		if(!$this->session->userdata('username')){
		$this->load->view('loginbak');
		}
		else {
			return header("location:/admin/admin/read");
		}
	}

	public function auth()
	{		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$where = [
			'username' => $username,
			'password' => md5($password)
		];

		$cariData = $this->mymodel->cek($where);
		if ($cariData) {
			$data_session = [
				'username' => $username,
				'status' => "login",
				'level' => $cariData['level']
			];
			$this->session->set_userdata($data_session);
			if($cariData['level'] == 1){
				return header("location:/admin/admin");
			}
			if($cariData['level'] == 2){
				return header("location:/user/user");
			}
			if($cariData['level'] == 3){
				return header("location:/user/user");
			}
			
		} else {
			echo "<script> alert('Username / Password Salah!'); window.location = '../login'</script>";
		}
		
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}

	function addAdmin()
	{
		$this->form_validation->set_rules('username','Username','required|callback_check_username_exists');
		$this->form_validation->set_rules('nama_Admin','Nama User','required|min_length[3]');
		$this->form_validation->set_rules('password','Password','required|min_length[5]|matches[cpassword]');
		$this->form_validation->set_rules('cpassword','Password','required|min_length[5]');
		$this->form_validation->set_rules('level','Level','required');
		
		$data_add = [
			'username' => $this->input->post('username'),
			'nama_Admin' => $this->input->post('nama_Admin'),
			'password' => $this->input->post('password'),
			'level' => $this->input->post('level')
		];
		// $cek_username = $this->mymodel->admin($data_add['username']);

		// else{
		// // var_dump($data_add);
		// $tambah = $this->mymodel->tambah_data($data_add);
		// echo "inserted with object id ".$tambah->getInsertedId();
		// }
		if($this->form_validation->run() != false){
			echo "Form validation oke";
		}else{
			$this->load->view('signuperr',$data_add);
		}
	}

	public function check_username_exists($username)
	{
	   if(!$this->mymodel->admin($username)){
	   return true;
	   } else {
		$this->form_validation->set_message('check_username_exists', 'Username Sudah ada. Gunakan username lain');
	   return false;
	   }
	}
}
