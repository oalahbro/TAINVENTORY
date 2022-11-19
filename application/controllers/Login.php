<?php
defined('BASEPATH') or exit('No direct script access allowed');

class login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('M_admin');
		$this->load->model('M_login');
	}

	public function index()
	{

		if ($this->session->userdata('level') == 1) {
			redirect(base_url() . "admin/admin");
		}
		if ($this->session->userdata('level') == 2) {
			redirect(base_url() . "guru/guru");
		}
		if ($this->session->userdata('level') == 3) {
			redirect(base_url() . "buyer/buyer");
		} else {
			// return view('login');
			return view('login');
		}
	}

	public function apiAuth()
	{
		if (!$this->session->userdata('username')) {

			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$where = [
				'username' => $username,
				'password' => md5($password)
			];
			$salah = ['respon' => 'salah'];
			$inactive = ['respon' => 'inactive'];
			$cariData = $this->M_login->cek($where);
			if ($cariData) {
				$data_session = [
					'username' => $username,
					'status' => "login",
					'level' => $cariData['level'],
					'id' => $cariData['id_admin']
				];
				if ($cariData['level'] == 1 && $cariData['status'] == 1) {
					$this->session->set_userdata($data_session);
					$benar = [
						'respon' => 'benar',
						'link' => 'admin/admin'
					];
					echo json_encode($benar);
				} else if ($cariData['level'] == 2 && $cariData['status'] == 1) {
					$this->session->set_userdata($data_session);
					$benar = [
						'respon' => 'benar',
						'link' => 'guru/guru'
					];
					echo json_encode($benar);
				} else if ($cariData['level'] == 3 && $cariData['status'] == 1) {
					$this->session->set_userdata($data_session);
					$benar = [
						'respon' => 'benar',
						'link' => 'buyer/buyer'
					];
					echo json_encode($benar);
				} else {
					echo json_encode($inactive);
				}
			} else {
				echo json_encode($salah);
			}
		} else {
			redirect(base_url('admin/admin'));
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}

	function signup()
	{

		if (!$this->session->userdata('username')) {

			$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|callback_check_username_exists');
			$this->form_validation->set_rules('nama_Admin', 'Nama User', 'required|min_length[3]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|matches[cpassword]');
			$this->form_validation->set_rules('cpassword', 'Password', 'required|min_length[5]');
			$this->form_validation->set_rules('level', 'Level', 'required');

			$data_add = [
				'username' => $this->input->post('username'),
				'nama_Admin' => $this->input->post('nama_Admin'),
				'password' => $this->input->post('password'),
				'level' => $this->input->post('level')
			];

			if ($this->form_validation->run() != false) {
				$this->M_login->addData($data_add);
				$success['danger'] = '<script type="text/javascript">
			swal({
			title: "Signup Berhasil",
			text: "Silahkan login menggunakan Username / Password anda",
			icon: "success",
			buttons: "OK",
			})
			</script>';
				return view('login', $success);
			} else {
				return view('login', $data_add);
			}
		} else {
			$this->index();
		}
	}

	public function check_username_exists($username)
	{
		if (!$this->M_admin->admin($username)) {
			return true;
		} else {
			$this->form_validation->set_message('check_username_exists', 'Username Sudah ada. Gunakan username lain');
			return false;
		}
	}

	public function forgot()
	{
		$cekuname = $this->M_admin->admin($this->input->post('username'));
		if (!$cekuname) {
			$data = null;
			echo json_encode($data);
		} else {
			$data = $cekuname;
			echo json_encode($data);
			$otp = ['otp' => (rand(100, 999)) . (rand(100, 999))];
			$this->session->set_userdata($otp);
			$url = 'http://127.0.0.1:3000/otp';
			$datawa = [
				'pesan' => 'Kode Otp anda ' . $otp['otp'],
				'nomer' => $cekuname['telp']
			];
			$options = array(
				'http' => array(
					'header' => "Content-type: application/x-www-form-urlencoded\r\n",
					'method' => 'POST',
					'content' => http_build_query($datawa)
				)
			);
			$context = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			if ($result === FALSE) {
			}
		}
	}
	public function otp()
	{
		if ($this->session->userdata('otp') == $this->input->post('otp')) {
			$data = "success";
			echo $data;
		} else {
			$data = "error";
			echo $data;
		}
	}
	public function resetpw()
	{
		$data =  $this->M_login->resetpwd();
		$this->session->sess_destroy();
		echo json_encode($data);
	}
	function info()
	{
		phpinfo();
	}
}
