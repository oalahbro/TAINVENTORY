<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

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
			'jumlah_unconfirmed' => count($this->M_admin->getUnconfirmed()),
			'user' => $this->dataAdmin()
		];
		return view('admin/dashboard', $data);
	}
	public function addInvt()
	{
		$data['planet'] = [
			'invt_tmp' => $this->M_admin->invtTmp(),
			'kategori' => $this->M_admin->getCategory(),
			'tuser' => $this->M_admin->getTuser(),
			'user' => $this->dataAdmin(),
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
			'user' => $this->dataAdmin(),
			'link' => 'userGet'
		];

		return view('admin/user', $data);
	}
	public function userGet()
	{
		$data =  $this->M_admin->getUser();
		echo json_encode($data);
	}
	public function addUser()
	{
		$data =  $this->M_admin->addUser();
		echo json_encode($data);
	}
	public function cekusername()
	{
		$data =  $this->M_admin->cekusername();
		echo json_encode($data);
	}
	public function delUser()
	{
		$data = $this->M_admin->deleteUser();
		echo json_encode($data);
	}
	public function detailUsr()
	{
		$data = $this->M_admin->detailUsr();
		if (!$data) {
			$data = ['respon' => 'kosong'];
		}
		echo json_encode($data);
	}
	public function updateUser()
	{
		$data = $this->M_admin->updatUsr();
		echo json_encode($data);
	}
	public function request()
	{
		$data['planet'] = [
			'back' => $this->M_admin->getBack(),
			'kategori' => $this->M_admin->getCategory(),
			'tuser' => $this->M_admin->getTuser(),
			'user' => $this->dataAdmin(),
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
			'user' => $this->dataAdmin(),
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
			'user' => $this->dataAdmin(),
			'link' => 'invtAll',
			'title' => 'Semua Inventory'
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
		$data = $this->M_admin->addCategory();
		echo json_encode($data);
	}
	public function updateCategory()
	{
		$data = $this->M_admin->updateCat();
		echo json_encode($data);
	}
	public function getKategori()
	{
		$data = $this->M_admin->getCategory();
		echo json_encode($data);
	}
	public function kategori()
	{
		$data['planet'] = [
			'user' => $this->dataAdmin(),
			'kategori' => $this->M_admin->getCategory(),
			'title' => "Kategori",
			'link' => "apiKat"
		];
		return view('admin/category', $data);
	}
	public function apiKat()
	{
		$data = $this->M_admin->apiCat();
		echo json_encode($data);
	}
	public function detailkat()
	{
		$catid = $_GET['id'];
		$data = $this->M_admin->detailCat($catid);
		if (!$data) {
			$data = ['respon' => 'kosong'];
		}
		echo json_encode($data);
	}
	public function delKategori()
	{
		$data = $this->M_admin->deleteCat();
		echo json_encode($data);
	}
	public function profile()
	{
		$data['planet'] = [
			'user' => $this->dataAdmin(),
			'title' => "Profile",
			'profile' => $this->M_admin->profile()
		];
		return view('admin/profile', $data);
	}
	public function cekpwd()
	{
		$data =  $this->M_admin->profile();
		echo json_encode($data);
	}
	public function resetpwd()
	{
		$data =  $this->M_admin->resetpwd();
		echo json_encode($data);
	}
}
