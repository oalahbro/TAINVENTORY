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
			return header("location:/admin/admin");
		}
		if ($this->session->userdata('level') == 2) {
			return header("location:/guru/guru");
		}
		if ($this->session->userdata('level') == 3) {
			return header("location:/buyer/buyer");
		} else {
			$this->load->view('login');
		}
	}

	public function auth()
	{
		if (!$this->session->userdata('username')) {

			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$where = [
				'username' => $username,
				'password' => md5($password)
			];
			$error['danger'] = '<script type="text/javascript">
			swal({
			title: "Username / Password Salah !",
			text: "Silahkan cek username / password anda kembali",
			icon: "warning",
			buttons: "OK",
			dangerMode: true,
			})
			</script>';
			$status['danger'] = '<script type="text/javascript">
			swal({
			title: "User belum aktif",
			text: "Silahkan hubungi administrator",
			icon: "warning",
			buttons: "OK",
			dangerMode: true,
			})
			</script>';

			$cariData = $this->M_login->cek($where);
			if ($cariData) {
				$data_session = [
					'username' => $username,
					'status' => "login",
					'level' => $cariData['level']
				];
				if ($cariData['level'] == 1 && $cariData['status'] == 1) {
					$this->session->set_userdata($data_session);
					return header("location:/admin/admin");
				} else {
					$this->load->view('login', $status);
				}
				if ($cariData['level'] == 2 && $cariData['status'] == 1) {
					$this->session->set_userdata($data_session);
					return header("location:/guru/guru");
				} else {
					$this->load->view('login', $status);
				}
				if ($cariData['level'] == 3 && $cariData['status'] == 1) {
					$this->session->set_userdata($data_session);
					return header("location:/buyer/buyer");
				} else {
					$this->load->view('login', $status);
				}
			} else {

				$this->load->view('login', $error);
			}
		} else {
			$this->index();
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
				$this->M_admin->tambah_data($data_add);
				$success['danger'] = '<script type="text/javascript">
			swal({
			title: "Signup Berhasil",
			text: "Silahkan login menggunakan Username / Password anda",
			icon: "success",
			buttons: "OK",
			})
			</script>';
				$this->load->view('login', $success);
			} else {
				$this->load->view('signuperr', $data_add);
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
	public function apinotif()
	{
		$api = '[
		{
			"name": "Quyn Mays",
			"email": "tempus@protonmail.ca",
			"phone": "1-867-835-6080"
		},
		{
			"name": "Wayne Buchanan",
			"email": "ornare.placerat@icloud.couk",
			"phone": "1-582-867-9444"
		},
		{
			"name": "Juliet Burks",
			"email": "dictum.placerat@outlook.couk",
			"phone": "1-517-224-9648"
		},
		{
			"name": "Juliet Burks",
			"email": "dictum.placerat@outlook.couk",
			"phone": "1-517-224-9648"
		},
		{
			"name": "Wayne Buchanan",
			"email": "ornare.placerat@icloud.couk",
			"phone": "1-582-867-9444"
		},
		{
			"name": "Juliet Burks",
			"email": "dictum.placerat@outlook.couk",
			"phone": "1-517-224-9648"
		},
		{
			"name": "Juliet Burks",
			"email": "dictum.placerat@outlook.couk",
			"phone": "1-517-224-9648"
		}
		
	]';

		$doom = json_decode($api, true);
		$data = [
			'jumlah' => count($doom),
			'get' => $doom


		];
		echo json_encode($data);
	}
	public function arra()
	{
		$this->load->view('notif');

		// $no = 1;
		// foreach ($doom as $d) {
		// 	echo '<form method="post" action="' . base_url() . 'login/arra">
		// 	<div class="form-row mb-2">
		// 	<div class="col"><input type="text"  class="form-control" name="nama' . $no . '[nama]" value="' . $d['name'] . '"/></div>
		// 	<div class="col"><input type="text"  class="form-control" name="nama' . $no . '[email]" value="' . $d['email'] . '"/></div>
		// 	<div class="col"><input type="text"  class="form-control" name="nama' . $no . '[phone]" value="' . $d['phone'] . '"/></div>
		// 	</div>
		// 	';
		// 	$no++;
		// }
		// echo '<button type="submit" class="btn btn-primary mt-2 mx-auto custom d-block">Submit</button></form>';
		// if ($this->input->post()) {
		// 	echo '<table class="table">
		// 		<thead>
		// 			<tr>
		// 			<th>Nama</th>
		// 			<th>Email</th>
		// 			<th>No Telp</th>
		// 			</tr>
		// 		</thead>';
		// 	foreach ($this->input->post() as $d) {
		// 		echo '
		// 		<tr>
		// 		  <td>' . $d['nama'] . '</td>
		// 		  <td>' . $d['email'] . '</td>
		// 		  <td>' . $d['phone'] . '</td>
		// 		</tr>
		// 		';
		// 		// echo $d['nama'];
		// 	}
		// 	echo '</table>';
		// 	// var_dump($this->input->post('nama1'));
		// }
		// echo '</div>';
	}
}
