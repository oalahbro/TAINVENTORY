<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	public function getCategory()
	{
		$table = $this->mongodb->table('category');
		$result = $table->find(['status' => '1'])->toArray();
		return $result;
	}
	public function getTuser()
	{
		$table = $this->mongodb->table('user');
		$result = $table->find(['$or' => [
			['level' => '3'],
			['level' => '2']
		], 'status' => '1'])->toArray();
		return $result;
	}
	public function updateReq()
	{
		$table = $this->mongodb->table('aset');
		$history = $this->mongodb->table('history');
		$result = $table->findOne(['id_aset' => $this->input->post('id_aset')]);
		if (!$this->input->post('img')) {
			$resultast = $table->aggregate(
				[
					['$match' => ['id_aset' => $this->input->post('id_aset')]],
					['$project' => [
						'_id' => 0,
						'id_user_tujuan' => 1,
						'id_category' => 1,
						'nama_aset' => 1,
						'spesifikasi' => 1,
						'deskripsi' => 1
					]]
				]
			)->toArray();
			$noimg = [
				'id_user_tujuan' => $this->input->post('tujuan'),
				'id_category' => $this->input->post('kategori'),
				'nama_aset' => $this->input->post('nama'),
				'spesifikasi' => $this->input->post('spesifikasi'),
				'deskripsi' => $this->input->post('deskripsi')
			];

			$arr = iterator_to_array($resultast[0]);
			$addd = array_diff_assoc($noimg, $arr);
			$kol = [];
			foreach ($addd as $key => $item) {
				if ($key == 'nama_aset') {
					$key = "nama aset";
				} elseif ($key == 'id_user_tujuan') {
					$key = "tujuan";
				} elseif ($key == 'id_category') {
					$key = "kategori";
				}
				$kol[] = $key;
			}
			$data = [
				'id_history' =>  $this->mongodb->id(),
				'id_aset' => $result['id_aset'],
				'id_user_asal' => $result['id_user_asal'],
				'id_user_tujuan' => $this->input->post('tujuan'),
				'id_category' => $this->input->post('kategori'),
				'nama_aset' => $this->input->post('nama'),
				'code' => $result['code'],
				'status' => $result['status'] . "E " . join(", ", $kol),
				'date' => date("Y-m-d H:i:s"),
			];
			$history->insertOne($data);
			$add =  $table->updateOne(
				['id_aset' => $this->input->post('id_aset')],
				[
					'$set' => $noimg
				]
			);
		} else {
			$add = $table->updateOne(
				['id_aset' => $this->input->post('id_aset')],
				[
					'$set' => [
						'id_user_tujuan' => $this->input->post('tujuan'),
						'id_category' => $this->input->post('kategori'),
						'nama_aset' => $this->input->post('nama'),
						'spesifikasi' => $this->input->post('spesifikasi'),
						'deskripsi' => $this->input->post('deskripsi'),
						'img' => $this->input->post('img')
					]
				]
			);
		}
		return $add;
	}
	public function getInventory()
	{
		$table = $this->mongodb->table('aset');
		$result = $table->find()->toArray();
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
	public function insInvt()
	{
		$table = $this->mongodb->table('aset_tmp');
		$tableaset = $this->mongodb->table('aset');
		$resulttmp = $table->aggregate(
			[
				['$match' => ['code' => $this->input->post('code')]],
				['$sort' => ['_id' => -1]],
				['$project' => [
					'id_aset_tmp' => 1,
					'nama_aset' => 1,
					'code' => 1
				]]
			]
		)->toArray();
		$resultast = $tableaset->aggregate(
			[
				['$match' => ['code' => $this->input->post('code')]],
				['$sort' => ['_id' => -1]],
				['$project' => [
					'id_aset' => 1,
					'nama_aset' => 1,
					'code' => 1
				]]
			]
		)->toArray();
		if (!$resultast and !$resulttmp) {
			$table->insertOne([
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
			$add = [
				'set' => 'sukses'
			];
		} else {
			if (!$resulttmp) {
				$add = [
					'set' => 'gagal',
					'nama_aset' => $resultast[0]["nama_aset"]
				];
			} else {
				$add = [
					'set' => 'gagal',
					'nama_aset' => $resulttmp[0]["nama_aset"]
				];
			}
		}
		return $add;
	}
	public function getTmp($asetid)
	{

		$table = $this->mongodb->table('aset_tmp');
		$result = $table->aggregate(
			[
				['$match' => ['id_aset_tmp' => $asetid]],
				['$sort' => ['_id' => -1]],
				['$lookup' => [
					'from' => 'user',
					'localField' => 'id_user_tujuan',
					'foreignField' => 'id_admin',
					'as' => 'tujuan_info'
				]],
				['$lookup' => [
					'from' => 'user',
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
	public function delTmp()
	{
		$table = $this->mongodb->table('aset_tmp');
		$updateResult = $table->deleteOne(
			['id_aset_tmp' => $this->input->post('id_aset_tmp')]
		);
		return $updateResult;
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
	public function descTmp()
	{
		$iduser = $this->session->userdata('id');
		$table = $this->mongodb->table('aset_tmp');
		$aset = $this->mongodb->table('aset');
		$history = $this->mongodb->table('history');
		$result = $table->findOne(['id_user_asal' => $iduser], ['sort' => ['_id' => -1]]);

		if ($result) {
			$data = [
				'id_aset' => $result['id_aset_tmp'],
				'id_user_asal' => $result['id_user_asal'],
				'id_user_tujuan' => $result['id_user_tujuan'],
				'id_category' => $result['id_category'],
				'nama_aset' => $result['nama_aset'],
				'code' => $result['code'],
				'spesifikasi' => $result['spesifikasi'],
				'deskripsi' => $result['deskripsi'],
				'img' => $result['img'],
				'status' => $result['status'],
				'date' => date("Y-m-d H:i:s")
			];
			$aset->insertOne($data);
			$history->insertOne([
				'id_history' => $this->mongodb->id(),
				'id_aset' => $result['id_aset_tmp'],
				'id_user_asal' => $result['id_user_asal'],
				'id_user_tujuan' => $result['id_user_tujuan'],
				'id_category' => $result['id_category'],
				'nama_aset' => $result['nama_aset'],
				'code' => $result['code'],
				'status' => $result['status'],
				'date' => date("Y-m-d H:i:s"),
			]);
			$table->deleteOne(
				['id_aset_tmp' => $result['id_aset_tmp']]
			);
		}
		return $result;
	}
	public function invtReq()
	{
		$iduser = $this->session->userdata('id');
		$table = $this->mongodb->table('aset');
		$result = $table->aggregate(
			[
				['$match' => ['id_user_asal' => $iduser, '$or' => [['status' => 'R1'], ['status' => 'R0'], ['status' => '1R0N'], ['status' => '1R1N']]]],
				['$sort' => ['_id' => -1]],
				['$lookup' => [
					'from' => 'user',
					'localField' => 'id_user_tujuan',
					'foreignField' => 'id_admin',
					'as' => 'tujuan_info'
				]],
				['$lookup' => [
					'from' => 'user',
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
					'id_aset' => 1,
					'nama_aset' => 1,
					'code' => 1,
					'status' => 1,
					'tujuan_info.nama_Admin' => 1,
				]]
			]
		)->toArray();
		return $result;
	}
	public function getBack()
	{
		$iduser = $this->session->userdata('id');
		$table = $this->mongodb->table('aset');
		$result = $table->aggregate(
			[
				['$match' => ['id_user_asal' => $iduser, 'status' => '1']],
				['$sort' => ['_id' => -1]],
				['$project' => [
					'id_aset' => 1,
					'nama_aset' => 1,
					'code' => 1
				]]
			]
		)->toArray();
		return $result;
	}
	public function updateBack()
	{
		$table = $this->mongodb->table('aset');
		$user = $this->mongodb->table('user');
		$history = $this->mongodb->table('history');
		$resultusr = $user->findOne(['id_admin' => $this->input->post('tujuan')]);
		$result = $table->findOne(['id_aset' => $this->input->post('id_aset')]);
		$iduser = $this->session->userdata('id');

		if ($resultusr['level'] == 2) {
			$set = [
				'id_user_tujuan' => $this->input->post('tujuan'),
				'id_user_asal' => $iduser,
				'deskripsi' => $this->input->post('deskripsi'),
				'status' => "R1"
			];
			$add = $table->updateOne(
				['id_aset' => $this->input->post('id_aset')],
				['$set' => $set]
			);
		} else {
			$set = [
				'id_user_tujuan' => $this->input->post('tujuan'),
				'id_user_asal' => $iduser,
				'deskripsi' => $this->input->post('deskripsi'),
				'status' => "R0"
			];
			$add = $table->updateOne(
				['id_aset' => $this->input->post('id_aset')],
				['$set' => $set]
			);
		}

		$data = [
			'id_history' =>  $this->mongodb->id(),
			'id_aset' => $result['id_aset'],
			'id_user_asal' => $set['id_user_asal'],
			'id_user_tujuan' => $set['id_user_tujuan'],
			'id_category' => $result['id_category'],
			'nama_aset' => $result['nama_aset'],
			'code' => $result['code'],
			'status' => $set['status'] . "F",
			'date' => date("Y-m-d H:i:s")
		];
		$history->insertOne($data);
		return $add;
	}
	public function getReq($asetid)
	{

		$table = $this->mongodb->table('aset');
		$result = $table->aggregate(
			[
				['$match' => ['id_aset' => $asetid]],
				['$sort' => ['_id' => -1]],
				['$lookup' => [
					'from' => 'user',
					'localField' => 'id_user_tujuan',
					'foreignField' => 'id_admin',
					'as' => 'tujuan_info'
				]],
				['$lookup' => [
					'from' => 'user',
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
	public function addReq()
	{
		$table = $this->mongodb->table('aset_tmp');
		$tableaset = $this->mongodb->table('aset');
		$history = $this->mongodb->table('history');
		$resulttmp = $table->aggregate(
			[
				['$match' => ['code' => $this->input->post('code')]],
				['$sort' => ['_id' => -1]],
				['$project' => [
					'id_aset_tmp' => 1,
					'nama_aset' => 1,
					'code' => 1
				]]
			]
		)->toArray();
		$resultast = $tableaset->aggregate(
			[
				['$match' => ['code' => $this->input->post('code')]],
				['$sort' => ['_id' => -1]],
				['$project' => [
					'id_aset' => 1,
					'nama_aset' => 1,
					'code' => 1
				]]
			]
		)->toArray();

		if (!$resultast and !$resulttmp) {
			$user = $this->mongodb->table('user');
			$result = $user->findOne(['id_admin' => $this->input->post('tujuan')]);
			if ($result['level'] == 2) {
				$data = [
					'id_aset' => $this->mongodb->id(),
					'id_user_asal' => $this->session->userdata('id'),
					'id_user_tujuan' => $this->input->post('tujuan'),
					'id_category' => $this->input->post('kategori'),
					'nama_aset' => $this->input->post('nama'),
					'code' => $this->input->post('code'),
					'spesifikasi' => $this->input->post('spesifikasi'),
					'deskripsi' => $this->input->post('deskripsi'),
					'img' => $this->input->post('img'),
					'status' => 'R1',
					'date' => date("Y-m-d H:i:s")
				];
				$tableaset->insertOne($data);
			} else {
				$data = [
					'id_aset' => $this->mongodb->id(),
					'id_user_asal' => $this->session->userdata('id'),
					'id_user_tujuan' => $this->input->post('tujuan'),
					'id_category' => $this->input->post('kategori'),
					'nama_aset' => $this->input->post('nama'),
					'code' => $this->input->post('code'),
					'spesifikasi' => $this->input->post('spesifikasi'),
					'deskripsi' => $this->input->post('deskripsi'),
					'img' => $this->input->post('img'),
					'status' => 'R0',
					'date' => date("Y-m-d H:i:s")
				];
				$tableaset->insertOne($data);
			}
			$history->insertOne([
				'id_history' => $this->mongodb->id(),
				'id_aset' => $data['id_aset'],
				'id_user_asal' => $this->session->userdata('id'),
				'id_user_tujuan' => $this->input->post('tujuan'),
				'id_category' => $this->input->post('kategori'),
				'nama_aset' => $this->input->post('nama'),
				'code' => $this->input->post('code'),
				'status' => $data['status'],
				'date' => date("Y-m-d H:i:s")
			]);
			$add = [
				'set' => 'sukses'
			];
		} else {
			if (!$resulttmp) {
				$add = [
					'set' => 'gagal',
					'nama_aset' => $resultast[0]["nama_aset"]
				];
			} else {
				$add = [
					'set' => 'gagal',
					'nama_aset' => $resulttmp[0]["nama_aset"]
				];
			}
		}
		return $add;
	}
	public function unAccept()
	{
		$table = $this->mongodb->table('aset');
		$history = $this->mongodb->table('history');
		$result = $table->findOne(['id_aset' => $this->input->post('id_aset')]);
		$add = $table->updateOne(
			['id_aset' => $this->input->post('id_aset')],
			[
				'$set' => [
					'id_user_tujuan' => '',
					'id_user_asal' => $this->session->userdata('id'),
					'status' => "1",
					'date' => date("Y-m-d H:i:s")
				]
			]
		);
		$data = [
			'id_history' =>  $this->mongodb->id(),
			'id_aset' => $result['id_aset'],
			'id_user_asal' => $this->session->userdata('id'),
			'id_user_tujuan' =>  "",
			'id_category' =>  $result['id_category'],
			'nama_aset' =>  $result['nama_aset'],
			'code' => $result['code'],
			'status' => $result['status'] . "Y",
			'date' => date("Y-m-d H:i:s"),
		];
		$history->insertOne($data);
		$respon = $add->getModifiedCount();
		return $respon;
	}
	public function unDecline()
	{
		$table = $this->mongodb->table('aset');
		$history = $this->mongodb->table('history');
		$result = $table->findOne(['id_aset' => $this->input->post('id_aset')]);
		$add = $table->updateOne(
			['id_aset' => $this->input->post('id_aset')],
			[
				'$set' => [
					'status' => "1" . $result['status'] . "N",
					'date' => date("Y-m-d H:i:s")
				]
			]
		);
		$data = [
			'id_history' =>  $this->mongodb->id(),
			'id_aset' => $result['id_aset'],
			'id_user_asal' => $result['id_user_asal'],
			'id_user_tujuan' =>  $result['id_user_tujuan'],
			'id_category' =>  $result['id_category'],
			'nama_aset' =>  $result['nama_aset'],
			'code' => $result['code'],
			'status' => $result['status'] . "N",
			'date' => date("Y-m-d H:i:s"),
		];
		$history->insertOne($data);
		$respon = $add->getModifiedCount();
		return $respon;
	}
	public function getAdmin()
	{
		$table = $this->mongodb->table('user');
		$result = $table->find()->toArray();
		return $result;
	}
	public function getCategoryall()
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
	public function invtUnc()
	{
		$iduser = $this->session->userdata('id');
		$table = $this->mongodb->table('aset');
		$result = $table->aggregate(
			[
				['$match' => ['id_user_tujuan' => $iduser, '$or' => [['status' => 'R1'], ['status' => 'R0']]]],
				['$sort' => ['_id' => -1]],
				['$lookup' => [
					'from' => 'user',
					'localField' => 'id_user_asal',
					'foreignField' => 'id_admin',
					'as' => 'asal_info'
				]],
				['$lookup' => [
					'from' => 'user',
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
					'id_aset' => 1,
					'nama_aset' => 1,
					'code' => 1,
					'asal_info.nama_Admin' => 1,
					'status' => 1
				]]
			]
		)->toArray();
		return $result;
	}
	public function getHis($asetid)
	{

		$table = $this->mongodb->table('history');
		$result = $table->aggregate(
			[
				['$match' => ['id_aset' => $asetid]],
				['$sort' => ['_id' => -1]],
				['$lookup' => [
					'from' => 'user',
					'localField' => 'id_user_tujuan',
					'foreignField' => 'id_admin',
					'as' => 'tujuan_info'
				]],
				['$lookup' => [
					'from' => 'user',
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
					'id_user_asal' => 1,
					'id_user_tujuan' => 1,
					'id_category' => 1,
					'nama_aset' => 1,
					'code' => 1,
					'spesifikasi' => 1,
					'deskripsi' => 1,
					'date' => 1,
					'status' => 1,
					'tujuan_info.nama_Admin' => 1,
					'user_info.nama_Admin' => 1,
					'kategori_info.nama_kategori' => 1
				]]
			]
		)->toArray();
		return $result;
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
		$table = $this->mongodb->table('user');
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
