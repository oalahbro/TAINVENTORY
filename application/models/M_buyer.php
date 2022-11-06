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
		$table = $this->mongodb->table('user');
		$result = $table->find()->toArray();
		return $result;
	}

	public function getTuser()
	{
		$table = $this->mongodb->table('user');
		$result = $table->find(['level' => '1', 'status' => '1'])->toArray();
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
				]]
			]
		)->toArray();
		return $result;
	}
	public function dropdwn()
	{
		$admin = $this->mongodb->table('user');
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
				['$match' => ['id_user_asal' => $iduser, '$or' => [['status' => 'R1'],  ['status' => 'R1N']]]],
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
				['$match' => ['id_user_asal' => $iduser, 'status' => '0']],
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

		if ($resultusr['level'] == 1) {
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
	public function delReq()
	{
		$table = $this->mongodb->table('aset');
		$history = $this->mongodb->table('history');
		$result = $table->findOne(['id_aset' => $this->input->post('id_aset')]);
		$data = [
			'id_history' =>  $this->mongodb->id(),
			'id_aset' => $result['id_aset'],
			'id_user_asal' => $result['id_user_asal'],
			'id_user_tujuan' => $result['id_user_tujuan'],
			'id_category' => $result['id_category'],
			'nama_aset' => $result['nama_aset'],
			'code' => $result['code'],
			'status' => $result['status'] . "D",
			'date' => date("Y-m-d H:i:s")
		];
		$history->insertOne($data);

		$updateResult = $table->deleteOne(
			['id_aset' => $this->input->post('id_aset')]
		);
		return $updateResult;
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
			$history->insertOne([
				'id_history' =>  $this->mongodb->id(),
				'id_aset' => $data['id_aset'],
				'id_user_asal' => $this->session->userdata('id'),
				'id_user_tujuan' => $this->input->post('tujuan'),
				'id_category' => $this->input->post('kategori'),
				'nama_aset' => $this->input->post('nama'),
				'code' => $this->input->post('code'),
				'status' => 'R1',
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
	public function updateInv()
	{
		$table = $this->mongodb->table('aset');
		$history = $this->mongodb->table('history');
		$result = $table->findOne(['id_aset' => $this->input->post('id_aset')]);
		$resultast = $table->aggregate(
			[
				['$match' => ['id_aset' => $this->input->post('id_aset')]],
				['$project' => [
					'_id' => 0,
					'id_category' => 1,
					'nama_aset' => 1,
					'img' => 1,
					'spesifikasi' => 1,
					'deskripsi' => 1
				]]
			]
		)->toArray();
		if ($result['id_user_asal'] == $this->session->userdata('id')) {
			if (!$this->input->post('img')) {
				$dataup = [
					'id_category' => $this->input->post('kategori'),
					'nama_aset' => $this->input->post('nama'),
					'spesifikasi' => $this->input->post('spesifikasi'),
					'deskripsi' => $this->input->post('deskripsi')
				];
				$table->updateOne(
					['id_aset' => $this->input->post('id_aset')],
					[
						'$set' => $dataup
					]
				);
			} else {
				$dataup = [
					'id_category' => $this->input->post('kategori'),
					'nama_aset' => $this->input->post('nama'),
					'spesifikasi' => $this->input->post('spesifikasi'),
					'deskripsi' => $this->input->post('deskripsi'),
					'img' => $this->input->post('img')
				];
				$table->updateOne(
					['id_aset' => $this->input->post('id_aset')],
					[
						'$set' => $dataup
					]
				);
			}

			$arr = iterator_to_array($resultast[0]);
			$addd = array_diff_assoc($dataup, $arr);
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
				'id_category' => $this->input->post('kategori'),
				'nama_aset' => $this->input->post('nama'),
				'code' => $result['code'],
				'status' => $result['status'] . "E ",
				'date' => date("Y-m-d H:i:s"),
				'deskripsi' => join(", ", $kol)
			];
			$history->insertOne($data);
			$add = ['respon' => 'sukses'];
		} else {
			$add = ['respon' => 'gagal'];
		}

		return $add;
	}
	public function updateReq()
	{
		$table = $this->mongodb->table('aset');
		$history = $this->mongodb->table('history');
		$result = $table->findOne(['id_aset' => $this->input->post('id_aset')]);
		if ($result['status'] == 'R1N') {
			$result['status'] = 'R1';
		}
		$resultast = $table->aggregate(
			[
				['$match' => ['id_aset' => $this->input->post('id_aset')]],
				['$project' => [
					'_id' => 0,
					'id_user_tujuan' => 1,
					'id_category' => 1,
					'nama_aset' => 1,
					'spesifikasi' => 1,
					'deskripsi' => 1,
					'status' => 1,
				]]
			]
		)->toArray();
		if (!$this->input->post('img')) {
			$dataup = [
				'id_user_tujuan' => $this->input->post('tujuan'),
				'id_category' => $this->input->post('kategori'),
				'nama_aset' => $this->input->post('nama'),
				'spesifikasi' => $this->input->post('spesifikasi'),
				'deskripsi' => $this->input->post('deskripsi'),
				'status' => $result['status']
			];
			$add =  $table->updateOne(
				['id_aset' => $this->input->post('id_aset')],
				[
					'$set' => $dataup
				]
			);
		} else {
			$dataup = [
				'id_user_tujuan' => $this->input->post('tujuan'),
				'id_category' => $this->input->post('kategori'),
				'nama_aset' => $this->input->post('nama'),
				'spesifikasi' => $this->input->post('spesifikasi'),
				'deskripsi' => $this->input->post('deskripsi'),
				'img' => $this->input->post('img'),
				'status' => $result['status']
			];
			$add = $table->updateOne(
				['id_aset' => $this->input->post('id_aset')],
				[
					'$set' => $dataup
				]
			);
		}
		$arr = iterator_to_array($resultast[0]);
		$addd = array_diff_assoc($dataup, $arr);
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
			'status' => $result['status'] . "E",
			'date' => date("Y-m-d H:i:s"),
			'deskripsi' => join(", ", $kol)
		];
		$history->insertOne($data);
		return $add;
	}
	public function invtUnc()
	{
		$iduser = $this->session->userdata('id');
		$table = $this->mongodb->table('aset');
		$result = $table->aggregate(
			[
				['$match' => ['id_user_tujuan' => $iduser, 'status' => 'R0']],
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
				]]
			]
		)->toArray();
		return $result;
	}
	public function getUnc($asetid)
	{

		$table = $this->mongodb->table('aset');
		$result = $table->aggregate(
			[
				['$match' => ['id_aset' => $asetid]],
				['$sort' => ['_id' => -1]],
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
					'user_info.nama_Admin' => 1,
					'kategori_info.nama_kategori' => 1
				]]
			]
		)->toArray();
		return $result;
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
					'status' => "0",
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
					'status' => $result['status'] . "N",
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
			'status' => $result['status'] . "N",
			'date' => date("Y-m-d H:i:s"),
		];
		$history->insertOne($data);
		$respon = $add->getModifiedCount();
		return $respon;
	}
	public function invtAll()
	{
		$iduser = $this->session->userdata('id');
		$table = $this->mongodb->table('aset');
		$result = $table->aggregate(
			[
				[
					'$match' => [
						'$or' => [
							['status' => '1'],
							['status' => '0'],
							['status' => 'R1N'],
							['status' => 'R0N']
						]
					]
				],
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
					'id_user_asal' => 1,
					'nama_aset' => 1,
					'code' => 1,
					'status' => 1,
					'user_info.nama_Admin' => 1
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

	function admin($where)
	{
		$table = $this->mongodb->table('user');
		$result = $table->findOne(['username' => $where]);
		return $result;
	}
}
