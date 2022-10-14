<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buyer extends CI_Controller
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
		$this->load->model('M_buyer');
		if ($this->session->userdata('level') != 3) {
			redirect(base_url("login"));
		}
	}

	public function index()
	{

		$data['planet'] = [
			'jumlah' => count($this->M_buyer->getAdmin()),
			'jumlah_aset' => count($this->M_buyer->getInventory()),
			'user' => $this->M_buyer->admin($this->session->userdata('username')),
			'title' => 'Dashboard'
		];

		return view('buyer/dashboard', $data);
	}

	public function addInvt()
	{
		if (!$this->input->post()) {
			$data['planet'] = [
				'invt_tmp' => $this->M_buyer->invtTmp(),
				'kategori' => $this->M_buyer->getCategory(),
				'tuser' => $this->M_buyer->getTuser(),
				'user' => $this->M_buyer->admin($this->session->userdata('username')),
				'title' => 'Masukkan'
			];
			return view('buyer/addInvt', $data);
		} else {
			$this->M_buyer->insInvt();
			$data['planet'] = [
				'drop' => $this->M_buyer->dropdwn(),
				'value' => $this->input->post(),
				'invt_tmp' => $this->M_buyer->invtTmp(),
				'kategori' => $this->M_buyer->getCategory(),
				'tuser' => $this->M_buyer->getTuser(),
				'user' => $this->M_buyer->admin($this->session->userdata('username')),
				'title' => 'Masukkan'
			];
			return view('buyer/addAgn', $data);
			// var_dump($data['planet']['drop']['rescat']['nama_kategori']);
		}
	}

	public function api()
	{
		$asetid = $_GET['asetid'];
		$data = $this->M_buyer->getTmp($asetid);
		echo json_encode($data);
	}

	public function getTmp()
	{
		$data = $this->M_buyer->invtTmp();
		echo json_encode($data);
	}
	public function updateTmp()
	{
		$this->M_buyer->updateTmp();
	}

	public function pass()
	{
		$this->M_buyer->insInvt();
	}

	public function delTmp()
	{
		$this->M_buyer->delTmp();
	}
	public function insInvt()
	{
		$this->M_buyer->insInvt();
	}

	public function reqInvt()
	{
		$data = $this->M_buyer->descTmp();

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

	public function aggregate()
	{
		$resultt = $this->M_buyer->invtTmp();

		var_dump($resultt);
	}

	public function upload()
	{
		$this->load->view('upload');
	}

	public function unconfirmed()
	{
		$data['planet'] = [
			'jumlah' => count($this->M_buyer->getAdmin()),
			'jumlah_aset' => count($this->M_buyer->getInventory()),
			'user' => $this->M_buyer->admin($this->session->userdata('username')),
			'title' => 'Inventory Unconfirmed'
		];
		return view('buyer/unconfirmed', $data);
	}

	public function apiReq()
	{
		$data =  $this->M_buyer->invtReq();
		echo json_encode($data);
	}

	public function invtAll()
	{
		$data =  $this->M_buyer->invtAll();
		echo json_encode($data);
	}

	public function request()
	{
		$data['planet'] = [
			'back' => $this->M_buyer->getBack(),
			'kategori' => $this->M_buyer->getCategory(),
			'tuser' => $this->M_buyer->getTuser(),
			'user' => $this->M_buyer->admin($this->session->userdata('username')),
			'inventory' => $this->M_buyer->invtReq(),
			'link' => 'apiReq',
			'title' => 'Inventory Request'
		];
		return view('buyer/request', $data);
	}
	public function dataBack()
	{
		$data = $this->M_buyer->getBack();
		echo json_encode($data);
	}
	public function delReq()
	{
		$this->M_buyer->delReq();
	}

	public function addReq()
	{
		$this->M_buyer->addReq();
	}

	public function getReq()
	{
		$asetid = $_GET['asetid'];
		$data = $this->M_buyer->getReq($asetid);
		echo json_encode($data);
	}

	public function updateReq()
	{
		$data = $this->M_buyer->updateReq();
		echo json_encode($data);
	}

	public function backReq()
	{
		$this->M_buyer->updateBack();
	}

	public function aset()
	{
		$data['planet'] = [
			'jumlah' => count($this->M_buyer->getAdmin()),
			'jumlah_aset' => count($this->M_buyer->getInventory()),
			'user' => $this->M_buyer->admin($this->session->userdata('username')),
			'inventory' => $this->M_buyer->invtReq(),
			'link' => 'invtAll',
			'title' => 'Inventory Request'
		];
		return view('buyer/request', $data);
	}

	public function cek()
	{
		var_dump($this->M_buyer->getBack());
	}
}
