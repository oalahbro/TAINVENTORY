<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_buyer extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	public function getInventory()
	{
		$table = $this->mongodb->table('aset');
		$result = $table->find()->toArray();
		return $result;
	}
	public function getAdmin()
	{
		$table = $this->mongodb->table('admin');
		$result = $table->find()->toArray();
		return $result;
	}

	public function getTuser()
	{
		$table = $this->mongodb->table('admin');
		$result = $table->find(['level' => '1'])->toArray();
		return $result;
	}

	public function getCategory()
	{
		$table = $this->mongodb->table('category');
		$result = $table->find(['status' => '1'])->toArray();
		return $result;
	}
	public function invtTmp()
	{
		$iduser = $this->session->userdata('id');
		$table = $this->mongodb->table('aset_tmp');
		$result = $table->aggregate(
			[
				['$match' => ['id_user_asal' => $iduser]],
				['$sort' => ['_id' => -1]],
				['$project' => [
					'id_aset_tmp' => 1,
					'nama_aset' => 1,
					'code' => 1
				]]
			]
		)->toArray();
		return $result;
	}
	public function getTmp($asetid)
	{

		$table = $this->mongodb->table('aset_tmp');
		$result = $table->aggregate(
			[
				['$match' => ['id_aset_tmp' => $asetid]],
				['$sort' => ['_id' => -1]],
				['$lookup' => [
					'from' => 'admin',
					'localField' => 'id_user_tujuan',
					'foreignField' => 'id_admin',
					'as' => 'tujuan_info'
				]],
				['$lookup' => [
					'from' => 'admin',
					'localField' => 'id_user_asal',
					'foreignField' => 'id_admin',
					'as' => 'user_info'
				]],
				['$lookup' => [
					'from' => 'category',
					'localField' => 'id_category',
					'foreignField' => 'id_kategori',
					'as' => 'kategori_info'
				]],
				['$project' => [
					'id_aset_tmp' => 1,
					'id_user_asal' => 1,
					'id_user_tujuan' => 1,
					'id_category' => 1,
					'nama_aset' => 1,
					'code' => 1,
					'spesifikasi' => 1,
					'deskripsi' => 1,
					'img' => 1,
					'status' => 1,
					'tujuan_info.nama_Admin' => 1,
					'user_info.nama_Admin' => 1,
					'kategori_info.nama_kategori' => 1
				]]
			]
		)->toArray();
		return $result;
	}
	public function agg()
	{

		$table = $this->mongodb->table('aset_tmp');
		// $result = $table->find([], ['sort' => ['_id' => -1]])
		// 	->toArray();
		$result = $table->aggregate(
			[
				// ['$match' => ['status' => 'R']],
				['$sort' => ['_id' => -1]],
				['$lookup' => [
					'from' => 'admin',
					'localField' => 'id_user_tujuan',
					'foreignField' => 'id_admin',
					'as' => 'tujuan_info'
				]],
				['$lookup' => [
					'from' => 'admin',
					'localField' => 'id_user_asal',
					'foreignField' => 'id_admin',
					'as' => 'user_info'
				]]
			]
		)->toArray();
		return $result;
	}
	public function dropdwn()
	{
		$admin = $this->mongodb->table('admin');
		$resadm = $admin->findOne(['id_admin' => $this->input->post('tujuan')]);
		$cat = $this->mongodb->table('category');
		$rescat = $cat->findOne(['id_kategori' => $this->input->post('kategori')]);
		$result = [
			'resadm' => $resadm,
			'rescat' => $rescat
		];
		return $result;
	}
	public function insInvt()
	{
		$table = $this->mongodb->table('aset_tmp');
		if (!$this->input->post('img')) {
			$add = $table->insertOne([
				'id_aset_tmp' => $this->mongodb->id(),
				'id_user_asal' => $this->session->userdata('id'),
				'id_user_tujuan' => $this->input->post('tujuan'),
				'id_category' => $this->input->post('kategori'),
				'nama_aset' => $this->input->post('nama'),
				'code' => $this->input->post('code'),
				'spesifikasi' => $this->input->post('spesifikasi'),
				'deskripsi' => $this->input->post('deskripsi'),
				'img' => $this->input->post('img_old'),
				'status' => 'R1'
			]);
		} else {
			$add = $table->insertOne([
				'id_aset_tmp' => $this->mongodb->id(),
				'id_user_asal' => $this->session->userdata('id'),
				'id_user_tujuan' => $this->input->post('tujuan'),
				'id_category' => $this->input->post('kategori'),
				'nama_aset' => $this->input->post('nama'),
				'code' => $this->input->post('code'),
				'spesifikasi' => $this->input->post('spesifikasi'),
				'deskripsi' => $this->input->post('deskripsi'),
				'img' => $this->input->post('img'),
				'status' => 'R1'
			]);
		}

		return $add;
	}

	public function updateTmp()
	{
		$table = $this->mongodb->table('aset_tmp');
		if (!$this->input->post('img')) {
			$add = $table->updateOne(
				['id_aset_tmp' => $this->input->post('id_aset')],
				[
					'$set' => [
						'id_user_tujuan' => $this->input->post('tujuan'),
						'id_category' => $this->input->post('kategori'),
						'nama_aset' => $this->input->post('nama'),
						'code' => $this->input->post('code'),
						'spesifikasi' => $this->input->post('spesifikasi'),
						'deskripsi' => $this->input->post('deskripsi')
					]
				]
			);
		} else {
			$add = $table->updateOne(
				['id_aset_tmp' => $this->input->post('id_aset')],
				[
					'$set' => [
						'id_user_tujuan' => $this->input->post('tujuan'),
						'id_category' => $this->input->post('kategori'),
						'nama_aset' => $this->input->post('nama'),
						'code' => $this->input->post('code'),
						'spesifikasi' => $this->input->post('spesifikasi'),
						'deskripsi' => $this->input->post('deskripsi'),
						'img' => $this->input->post('img')
					]
				]
			);
		}

		return $add;
	}

	public function delTmp()
	{
		$table = $this->mongodb->table('aset_tmp');
		$updateResult = $table->deleteOne(
			['id_aset_tmp' => $this->input->post('id_aset_tmp')]
		);
		return $updateResult;
	}
	public function add($datanya)
	{
		$table = $this->mongodb->table('aset');
		$tambah = $table->insertOne($datanya);
		return $tambah;
	}

	public function update($datanya)
	{
		$table = $this->mongodb->table('aset');
		$updateResult = $table->updateOne(
			['newCol' => 'dfghjkl;lkjhgfd'],
			[
				'$set' => [
					'newCol' => $datanya['newcol2']
				]
			]
		);
		return $updateResult;
	}

	function addAdmin($data_add)
	{
		$table = $this->mongodb->table('admin');
		$add = $table->insertOne([
			'id_admin' => $this->mongodb->id(),
			'nama_Admin' => $data_add['nama_Admin'],
			'username' => $data_add['username'],
			'katasandi' => md5($data_add['password']),
			'level' => $data_add['level']
		]);
		return $add;
	}

	function admin($where)
	{
		$table = $this->mongodb->table('admin');
		$result = $table->findOne(['username' => $where]);
		return $result;
	}

	function addCategory($data_add)
	{
		$table = $this->mongodb->table('category');
		$add = $table->insertOne([
			'id_kategori' => $this->mongodb->id(),
			'nama_kategori' => $data_add['nama_kategori'],
			'status' => $data_add['status']
		]);
		return $add;
	}

	public function updateCat($datanya)
	{
		$table = $this->mongodb->table('category');
		$updateResult = $table->updateOne(
			['id_kategori' => $datanya['id_kategori']],
			[
				'$set' => [
					'nama_kategori' => $datanya['nama_kategori'],
					'status' => $datanya['status']
				]
			]
		);
		return $updateResult;
	}

	public function deleteCat($datanya)
	{
		$table = $this->mongodb->table('category');
		$updateResult = $table->deleteOne(
			['id_kategori' => $datanya['id_kategori']]
		);
		return $updateResult;
	}
}
