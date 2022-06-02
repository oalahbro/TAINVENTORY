<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getData()
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
	public function getCategory()
	{
		$table = $this->mongodb->table('category');
		$result = $table->find()->toArray();
		return $result;
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
