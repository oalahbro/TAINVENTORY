<?php

use SebastianBergmann\Environment\Console;

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
	public function dataAdmin()
	{
		$data = $this->M_buyer->admin($this->session->userdata('username'));
		return $data;
	}
	public function nama_file()
	{
		$filename = "laporan" . date("Y-m-d|h:i:s") . ".pdf";
		return $filename;
	}
	public function index()
	{

		$data['planet'] = [
			'jumlah' => count($this->M_buyer->getAdmin()),
			'jumlah_aset' => count($this->M_buyer->getInventory()),
			'jumlah_unconfirmed' => count($this->M_buyer->getUnconfirmed()),
			'jumlah_sementara' => count($this->M_buyer->getSementara()),
			'user' => $this->M_buyer->admin($this->session->userdata('username')),
			'title' => 'Dashboard'
		];

		return view('buyer/dashboard', $data);
	}

	public function addInvt()
	{
		$data['planet'] = [
			'invt_tmp' => $this->M_buyer->invtTmp(),
			'kategori' => $this->M_buyer->getCategory(),
			'tuser' => $this->M_buyer->getTuser(),
			'user' => $this->M_buyer->admin($this->session->userdata('username')),
			'title' => 'Masukkan',
			'link' => ""
		];
		return view('buyer/addInvt', $data);
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
		$data = $this->M_buyer->insInvt();
		echo json_encode($data);
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
	public function tmpsend()
	{
		$data = $this->M_buyer->getno();
		$asal = $this->dataAdmin();
		$url = 'http://127.0.0.1:3000/submittmp';
		foreach ($data as $d) {
			$merg[] = $d['tujuan_info'][0]['telp'];
		}
		$count = array_count_values($merg);
		foreach ($count as $n => $val) {
			$datawa = [
				'pesan' => '*' . $asal['nama_Admin'] . '*' . ' Telah Melakukan Requset, dengan total : ' . $val . ' Aset',
				'nomer' => $n,
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
				echo "gagal";
			}
		}
	}
	public function aggregate()
	{
		$resultt = $this->M_buyer->invtTmp();
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
			'title' => 'Inventory Unconfirmed',
			'link' => 'apiUnc'
		];
		return view('buyer/unconfirmed', $data);
	}
	public function apiUnc()
	{
		$data =  $this->M_buyer->invtUnc();
		echo json_encode($data);
	}
	public function actionUnc()
	{
		if ($this->input->post('button') == 'accept') {
			$data =  $this->M_buyer->unAccept();
		} else {
			$data =  $this->M_buyer->unDecline();
		}
		echo json_encode($data);
	}
	public function apiReq()
	{
		$data =  $this->M_buyer->invtReq();
		echo json_encode($data);
	}

	public function invtAll()
	{
		$data =  $this->M_buyer->invtAll();
		array_push($data, ["sesid" => $this->session->userdata('id')]);
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
		$data = $this->M_buyer->addReq();
		echo json_encode($data);
	}
	public function addreqsend()
	{
		$no = $this->M_buyer->adminno($_GET['id_user_tujuan']);
		$asal = $this->dataAdmin();
		$url = 'http://127.0.0.1:3000/submittmp';
		print_r($no[0]['telp']);
		$datawa = [
			'pesan' => '*' . $asal['nama_Admin'] . '*' . " Telah Melakukan Requset\n" . 'Nama Aset : ' . $_GET['nama_aset'] . "\n" . 'Code : ' . $_GET['code'],
			'nomer' => $no[0]['telp'],
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
			echo "gagal";
		}
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
		$data = $this->M_buyer->getBacksend();
		$no = $this->M_buyer->adminno($this->input->post('tujuan'));
		$asal = $this->dataAdmin();
		$url = 'http://127.0.0.1:3000/submittmp';
		print_r($no[0]['telp']);
		$datawa = [
			'pesan' => '*' . $asal['nama_Admin'] . '*' . " Telah Melakukan Requset\n" . 'Nama Aset : ' . $data[0]['nama_aset'] . "\n" . 'Code : ' . $data[0]['code'],
			'nomer' => $no[0]['telp'],
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
			echo "gagal";
		}
	}

	public function gethis()
	{
		$asetid = $_GET['asetid'];
		$data = $this->M_buyer->getHis($asetid);
		echo json_encode($data);
	}

	public function aset()
	{
		$data['planet'] = [
			'jumlah' => count($this->M_buyer->getAdmin()),
			'jumlah_aset' => count($this->M_buyer->getInventory()),
			'kategori' => $this->M_buyer->getCategory(),
			'user' => $this->M_buyer->admin($this->session->userdata('username')),
			'link' => 'invtAll',
			'title' => 'Semua Inventory'
		];
		return view('buyer/inventory', $data);
	}
	public function updateInv()
	{
		$data = $this->M_buyer->updateInv();
		echo json_encode($data);
	}
	public function cek()
	{
		var_dump($this->M_buyer->getBack());
	}
	public function profile()
	{
		$data['planet'] = [
			'user' => $this->dataAdmin(),
			'title' => "Profile",
			'link' =>  "apiProfile"
		];
		return view('buyer/profile', $data);
	}
	public function apiProfile()
	{
		$data =  $this->M_buyer->profile();
		echo json_encode($data);
	}
	public function cekpwd()
	{
		$data =  $this->M_buyer->profile();
		if ($data['password'] == md5($_GET['pwd'])) {
			$respon = "ok";
		} else {
			$respon = "not ok";
		}
		echo json_encode($respon);
	}

	public function resetpwd()
	{
		$data =  $this->M_buyer->resetpwd();
		echo json_encode($data);
	}
	public function getimgprofile()
	{
		$data =  $this->M_buyer->profile();
		echo json_encode($data['img']);
	}
	public function updateImg()
	{
		$data =  $this->M_buyer->updateImg();
		echo json_encode($data);
	}
	public function updateProfile()
	{
		$data =  $this->M_buyer->updateProfile();
		echo json_encode($data);
	}
	public function report()
	{
		$data['planet'] = [
			'user' => $this->dataAdmin(),
			'tuser' => $this->M_buyer->getTuser(),
			'title' => "Laporan",
			'link' =>  "apiReport"
		];
		return view('buyer/report', $data);
	}
	public function apiReport()
	{
		$data =  $this->M_buyer->reportApi();
		array_push($data, ["sesid" => $this->session->userdata('id')]);
		echo json_encode($data);
	}
	public function filter()
	{
		$data =  $this->M_buyer->filter();
		echo json_encode($data);
	}
	public function cetak_pdf()
	{
		$this->load->library('pdf');
		$option = $this->pdf->getOptions();
		$option->set(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
		$data['laporan'] = $this->M_buyer->filter();
		$view = $this->load->view('template/laporan', $data);
		$html = $this->output->get_output($view);
		$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->load_html($html);
		$this->pdf->render();
		$this->pdf->filename = "laporan.pdf";
		$output = $this->pdf->output();
		file_put_contents('assets/' . $this->nama_file(), $output);
		header('location: ' . base_url('buyer/buyer/filename'));
	}
	public function filename()
	{
		echo $this->nama_file();
	}
	public function deletePdf()
	{
		$filename = $_GET['path'];
		unlink('assets' . DIRECTORY_SEPARATOR . $filename);
		echo json_encode("success");
	}
	public function search()
	{
		$data['planet'] = [
			'jumlah' => count($this->M_buyer->getAdmin()),
			'jumlah_aset' => count($this->M_buyer->getInventory()),
			'kategori' => $this->M_buyer->getCategory(),
			'tuser' => $this->M_buyer->getTuser(),
			'user' => $this->dataAdmin(),
			'link' => 'invtSearch?query=' . $this->input->post('search'),
			'title' => 'Search Inventory'
		];
		return view('buyer/inventory', $data);
	}
	public function invtSearch()
	{
		$search  = $_GET['query'];
		$data =  $this->M_buyer->invtSearch($search);
		array_push($data, ["sesid" => $this->session->userdata('id')]);
		echo json_encode($data);
	}
}
