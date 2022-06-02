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
			'jumlah_aset' => count($this->M_admin->getData()),
			'user' => $this->dataAdmin()
		];

		$this->load->view('template/headerAdmin', $data);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('template/footer');
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
			'jumlah' => count($this->M_admin->getAdmin()),
			'jumlah_aset' => count($this->M_admin->getData()),
			'user' => $this->dataAdmin()
		];
		$this->load->view('template/headerAdmin', $data);
		$this->load->view('admin/inventory', $data);
		$this->load->view('template/footer');
	}

	public function upload()
	{
		$data['planet'] = [
			'title' => "Dashboard",
			'user' => $this->dataAdmin()
		];

		$this->load->view('template/headerAdmin', $data);
		$this->load->view('uploadbak', $data);
		$this->load->view('template/footer');
	}

	public function read()
	{
		$data['planet'] = $this->M_admin->getData();
		// var_dump($data);
		$this->load->view('admin/test', $data);
	}

	public function insert()
	{
		$text = $this->input->post('text');
		$text2 = $this->input->post('text2');
		if (!$text && !$text2) {
			echo "kosong";
		} else {
			$datanya = [
				'newcol' => $text,
				'newcol2' => $text2
			];
			$this->M_admin->add($datanya);

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
		$this->M_admin->update($datanya);
		return header("location:/admin/admin/read");
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
	public function opo()
	{

		$data['boom'] = $this->input->post('text');
		$this->load->view('opo', $data);
	}
}
