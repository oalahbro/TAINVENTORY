<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$this->load->model('mymodel');
		if ($this->session->userdata('level') != 1) {
			redirect(base_url("login"));
		}
    }

	public function index()
	{
		$data['planet'] = [
			'jumlah' => count($this->mymodel->GetData()),
			'user' => $this->mymodel->admin($this->session->userdata('username'))
		];
		// var_dump($data['planet']['admin']['nama_Admin']);
		$this->load->view('admin/dashboardbak',$data);

		// $this->load->view('welcome_message');

	}

	public function upload()
	{

		$this->load->view('upload');

	}

	public function read()
	{
		$data['planet'] = $this->mymodel->GetData();
		// var_dump($data);
		$this->load->view('admin/test',$data);

	}
	// public function testpenduduk()
	// {
	// 	//var_dump($result);
	// 	$data['planet'] = $this->mymodel->TestPenduduk();
	// 	$this->load->view('test',$data);

	// }

	public function insert()
	{
		$text = $this->input->post('text');
		$text2 = $this->input->post('text2');
		if(!$text && !$text2){
			echo "kosong";
		}
		else{
		$datanya = [
			'newcol' => $text,
			'newcol2' => $text2
		];
		$this->mymodel->add($datanya);

        // echo "inserted with object id ".$tambah->getInsertedId();
		return header("location:/admin/admin/read");
		}

	}

	public function update()
	{
		$text2 = $this->input->post('text2');
		$datanya = [
			'newcol2' => $text2
		];
		$this->mymodel->update($datanya);
		return header("location:/admin/admin/read");
	}

	public function test()
	{
		$dat = $this->session->userdata('id_admin');
		var_dump($dat);
	}
}
