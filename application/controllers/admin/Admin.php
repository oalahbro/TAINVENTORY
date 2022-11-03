<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

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
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_admin');
		if ($this->session->userdata('level') != 1) {
			redirect(base_url("login"));
		}
	}
	public function dataAdmin()
	{
		$data = $this->M_admin->admin($this->session->userdata('username'));
		return $data;
	}

	public function index()
	{
		$data['planet'] = [
			'title' => "Dashboard",
			'jumlah' => count($this->M_admin->getAdmin()),
			'jumlah_aset' => count($this->M_admin->getInventory()),
			'user' => $this->dataAdmin()
		];
		// print_r($data);
		return view('admin/dashboard', $data);
	}
	public function addInvt()
	{
		$data['planet'] = [
			'invt_tmp' => $this->M_admin->invtTmp(),
			'kategori' => $this->M_admin->getCategory(),
			'tuser' => $this->M_admin->getTuser(),
			'user' => $this->M_admin->admin($this->session->userdata('username')),
			'title' => 'Masukkan'
		];
		// print_r($data['planet']['tuser']);
		return view('admin/addInvt', $data);
	}
	public function getTmp()
	{
		$data = $this->M_admin->invtTmp();
		echo json_encode($data);
	}
	public function pass()
	{
		$data = $this->M_admin->insInvt();
		echo json_encode($data);
		// var_dump($data);
	}
	public function api()
	{
		$asetid = $_GET['asetid'];
		$data = $this->M_admin->getTmp($asetid);
		echo json_encode($data);
	}
	public function delTmp()
	{
		$this->M_admin->delTmp();
	}
	public function updateTmp()
	{
		$this->M_admin->updateTmp();
	}
	public function reqInvt()
	{
		$data = $this->M_admin->descTmp();

		if (!$data) {
			$respon = [
				'respon' => 'habis'
			];
		} else {
			$respon = [
				'respon' => 'masih'
			];
		}
		echo json_encode($respon);
	}
	public function user()
	{
		$data['planet'] = [
			'title' => "User",
			'admin' => $this->M_admin->getAdmin(),
			'user' => $this->dataAdmin()
		];

		$this->load->view('template/headerAdmin', $data);
		$this->load->view('admin/user', $data);
		$this->load->view('template/footer');
	}

	public function inventory()
	{
		$data['planet'] = [
			'title' => "Inventory Unconfirmed",
			'inventory' => $this->M_admin->getInventory(),
			'user' => $this->dataAdmin()
		];
		var_dump($data['planet']['inventory']);
	}

	public function request()
	{
		$data['planet'] = [
			'back' => $this->M_admin->getBack(),
			'kategori' => $this->M_admin->getCategory(),
			'tuser' => $this->M_admin->getTuser(),
			'user' => $this->M_admin->admin($this->session->userdata('username')),
			'inventory' => $this->M_admin->invtReq(),
			'link' => 'apiReq',
			'title' => 'Inventory Request'
		];
		return view('admin/request', $data);
	}
	public function apiReq()
	{
		$data =  $this->M_admin->invtReq();
		echo json_encode($data);
	}
	public function backReq()
	{
		$this->M_admin->updateBack();
	}
	public function getReq()
	{
		$asetid = $_GET['asetid'];
		$data = $this->M_admin->getReq($asetid);
		if (!$data) {
			$data = ['respon' => 'kosong'];
		}
		echo json_encode($data);
	}
	public function addReq()
	{
		$data = $this->M_admin->addReq();
		echo json_encode($data);
	}
	public function updateReq()
	{
		$data = $this->M_admin->updateReq();
		echo json_encode($data);
	}
	public function gethis()
	{
		$asetid = $_GET['asetid'];
		$data = $this->M_admin->getHis($asetid);
		echo json_encode($data);
	}
	public function unconfirmed()
	{
		$data['planet'] = [
			'jumlah' => count($this->M_admin->getAdmin()),
			'jumlah_aset' => count($this->M_admin->getInventory()),
			'user' => $this->M_admin->admin($this->session->userdata('username')),
			'tuser' => $this->M_admin->getTuser(),
			'title' => 'Inventory Unconfirmed',
			'link' => 'apiUnc'
		];
		return view('admin/unconfirmed', $data);
	}
	public function apiUnc()
	{
		$data =  $this->M_admin->invtUnc();
		echo json_encode($data);
	}
	public function actionUnc()
	{
		if ($this->input->post('button') == 'accept') {
			$data =  $this->M_admin->unAccept();
		} else {
			$data =  $this->M_admin->unDecline();
		}
		echo json_encode($data);
	}
	public function aset()
	{
		$data['planet'] = [
			'jumlah' => count($this->M_admin->getAdmin()),
			'jumlah_aset' => count($this->M_admin->getInventory()),
			'kategori' => $this->M_admin->getCategory(),
			'tuser' => $this->M_admin->getTuser(),
			'user' => $this->M_admin->admin($this->session->userdata('username')),
			'link' => 'invtAll',
			'title' => 'Inventory'
		];
		return view('admin/inventory', $data);
	}
	public function invtAll()
	{
		$data =  $this->M_admin->invtAll();
		array_push($data, ["sesid" => $this->session->userdata('id')]);
		echo json_encode($data);
	}
	public function updateInv()
	{
		$data = $this->M_admin->updateInv();
		echo json_encode($data);
	}
	public function delReq()
	{
		$this->M_admin->delReq();
	}
	public function addCategory()
	{
		$data_add = [
			'nama_kategori' => ucwords($this->input->post('nama_kategori')),
			'status' => $this->input->post('status')
		];
		$data = "<script type='text/javascript'>$.notify({
            message: 'Sukses Menambah Kategori'
        }, {
            type: 'info',
            delay: 10000
        });
		</script>";
		$this->M_admin->addCategory($data_add);
		$this->session->set_flashdata('success', $data);
		return header("location:/admin/admin/kategori");
		// echo $this->session->flashdata('success');
	}
	public function updateCategory()

	{
		$datanya = [
			'id_kategori' => $this->input->post('id_kategori'),
			'nama_kategori' => ucwords($this->input->post('nama_kategori')),
			'status' => $this->input->post('status')
		];
		$this->M_admin->updateCat($datanya);
		return header("location:/admin/admin/kategori");
	}

	public function kategori()
	{
		$data['planet'] = [
			'user' => $this->dataAdmin(),
			'kategori' => $this->M_admin->getCategory(),
			'title' => "Kategori"
		];
		$this->load->view('template/headerAdmin', $data);
		$this->load->view('admin/category', $data);
		$this->load->view('template/footer');
	}

	public function getKategori()
	{
		$data = $this->M_admin->getCategory();
		echo json_encode($data);
	}

	public function delKategori()
	{
		$datanya = [
			'id_kategori' => $this->input->post('id_kategori')
		];
		$data = $this->M_admin->deleteCat($datanya);
		return header("location:/admin/admin/kategori");
	}
	public function tabel($title)
	{
		$table = $this->mongodb->table($title);
		return $table;
	}
	public function opo()
	{
		$result =  $this->M_admin->getCategory();
		var_dump($result);
	}
}
