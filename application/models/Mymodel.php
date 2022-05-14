<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mymodel extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
    }

	public function GetData(){
		$table = $this->mongodb->table('details');
		// $result = $table->find(['details' => 'PLEMBANG'],['limit' => 10])->toArray();
		$result = $table->find()->toArray();
		return $result;
	}

	public function TestPenduduk(){
		$table = $this->mongodb->table('penduduk');
		$result = $table->find(['ALAMAT' => 'GOLAN', 'NO_RW' => ['$lt' => '2']])->toArray();
		//$result = $table->find()->toArray();
		return $result;
	}

	public function add($datanya){
		$table = $this->mongodb->table('details');
		$tambah = $table->insertOne($datanya);
		return $tambah;
	}

	public function update($datanya){
		$table = $this->mongodb->table('details');
		$updateResult = $table->updateOne(
			['newCol' => 'dfghjkl;lkjhgfd'],
			['$set' => [
					'newCol' => $datanya['newcol2']
					]
			]
		);
		return $updateResult;
	}

	function tambah_data($data_add) {
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
}
?>