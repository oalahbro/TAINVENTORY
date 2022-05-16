<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mymodel extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
    }

	public function getData(){
		$table = $this->mongodb->table('aset');
		$result = $table->find()->toArray();
		return $result;
	}
	public function getAdmin(){
		$table = $this->mongodb->table('admin');
		$result = $table->find()->toArray();
		return $result;
	}

	public function add($datanya){
		$table = $this->mongodb->table('aset');
		$tambah = $table->insertOne($datanya);
		return $tambah;
	}

	public function update($datanya){
		$table = $this->mongodb->table('aset');
		$updateResult = $table->updateOne(
			['newCol' => 'dfghjkl;lkjhgfd'],
			['$set' => [
					'newCol' => $datanya['newcol2']
					]
			]
		);
		return $updateResult;
	}

	function addAdmin($data_add) {
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

	function cek($where) {
        $table = $this->mongodb->table('admin');
		$result = $table->findOne([
			'username' => $where['username'],
			'katasandi' => $where['password']
		]);
		return $result;
    }

	function admin($where) {
        $table = $this->mongodb->table('admin');
		$result = $table->findOne(['username' => $where]);
		return $result;
    }

	function addCategory($data_add) {
        $table = $this->mongodb->table('category');
		$add = $table->insertOne([
			'id_category' => $this->mongodb->id(),
			'nama_category' => $data_add['nama_category'],
		]);
		return $add;
    }
}
?>