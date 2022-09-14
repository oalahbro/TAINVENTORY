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

	public function show()
	{
		$this->load->view('opo');
	}

	public function pse()
	{
		$get = $_GET['id'];
		$ch = curl_init();

		// set url 
		curl_setopt($ch, CURLOPT_URL, "https://pse.kominfo.go.id/static/json-static/LOKAL_TERDAFTAR/" . $get . ".json");

		// return the transfer as a string 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string 
		$output = curl_exec($ch);

		// tutup curl 
		curl_close($ch);
		$k =  $output;
		$m = json_decode($k, true);
		// print_r($m[0]['data']);

		$lop = $m['data'];
		// foreach ($lop as $p) {
		// 	echo $p['id'] . '<br>';
		// 	echo $p['attributes']['nama'] . '<br><br>';
		// }
		echo json_encode($lop);
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
	public function api()
	{
		$url = 'http://127.0.0.1:3000/kirim';
		$data = [
			'pesan' => 'ahahahah',
			'nomer' => '62895338221298',
			// 'link' => base_url() . 'assets/ss.png'
			'link' => 'https://picsum.photos/720/800'
		];

		// use key 'http' even if you send the request to https://...
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) { /* Handle error */
		}

		var_dump($result);
	}

	function info()
	{
		phpinfo();
	}
}
