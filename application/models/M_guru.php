<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_guru extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	public function table($title)
	{
		$table = $this->mongodb->table($title);
		return $table;
	}
	public function getInventory()
	{
		$result = $this->table('aset')->find(['$or' => [
			['status' => '1'],
			['status' => '0'],
			['status' => 'R1N'],
			['status' => 'R0N']
		]])->toArray();
		return $result;
	}
	public function getUnconfirmed()
	{
		$result = $this->table('aset')->find(['id_user_tujuan' => $this->session->userdata('id'), 'status' => 'R1'])->toArray();
		return $result;
	}
	public function getRequest()
	{
		$result = $this->table('aset')->find(['id_user_asal' => $this->session->userdata('id'), 'status' => 'R0'])->toArray();
		return $result;
	}

	public function getAdmin()
	{
		$result = $this->table('user')->find(['status' => '1'])->toArray();
		return $result;
	}

	public function getTuser()
	{
		$result = $this->table('user')->find(['level' => '1', 'status' => '1'])->toArray();
		return $result;
	}

	public function getCategory()
	{
		$result = $this->table('category')->find(['status' => '1'])->toArray();
		return $result;
	}
	public function invtTmp()
	{
		$iduser = $this->session->userdata('id');
		$result = $this->table('aset_tmp')->aggregate(
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
	public function getno()
	{
		$result = $this->table('aset_tmp')->aggregate(
			[
				['$match' => ['id_user_asal' => $this->session->userdata('id')]],
				['$sort' => ['_id' => -1]],
				['$lookup' => [
					'from' => 'user',
					'localField' => 'id_user_tujuan',
					'foreignField' => 'id_admin',
					'as' => 'tujuan_info'
				]],
				['$project' => [
					'id_aset_tmp' => 1,
					'id_user_asal' => 1,
					'nama_aset' => 1,
					'code' => 1,
					'status' => 1,
					'tujuan_info.telp' => 1,
				]]
			]
		)->toArray();
		return $result;
	}
	public function getTmp($asetid)
	{
		$result = $this->table('aset_tmp')->aggregate(
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
		// $result = $table->find([], ['sort' => ['_id' => -1]])
		// 	->toArray();
		$result = $this->table('aset_tmp')->aggregate(
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
		$resadm = $this->table('user')->findOne(['id_admin' => $this->input->post('tujuan')]);
		$rescat = $this->table('category')->findOne(['id_kategori' => $this->input->post('kategori')]);
		$result = [
			'resadm' => $resadm,
			'rescat' => $rescat
		];
		return $result;
	}
	public function insInvt()
	{
		$resulttmp = $this->table('aset_tmp')->aggregate(
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
		$resultast = $this->table('aset')->aggregate(
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
			$this->table('aset_tmp')->insertOne([
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
		if (!$this->input->post('img')) {
			$add = $this->table('aset_tmp')->updateOne(
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
			$add = $this->table('aset_tmp')->updateOne(
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
		$updateResult = $this->table('aset_tmp')->deleteOne(
			['id_aset_tmp' => $this->input->post('id_aset_tmp')]
		);
		return $updateResult;
	}
	public function add($datanya)
	{
		$tambah = $this->table('aset')->insertOne($datanya);
		return $tambah;
	}

	public function descTmp()
	{
		$iduser = $this->session->userdata('id');
		$result = $this->table('aset_tmp')->findOne(['id_user_asal' => $iduser], ['sort' => ['_id' => -1]]);

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
			$this->table('aset')->insertOne($data);
			$this->table('history')->insertOne([
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
			$this->table('aset_tmp')->deleteOne(
				['id_aset_tmp' => $result['id_aset_tmp']]
			);
		}
		return $result;
	}

	public function invtReq()
	{
		$iduser = $this->session->userdata('id');
		$result = $this->table('aset')->aggregate(
			[
				['$match' => ['id_user_asal' => $iduser, '$or' => [['status' => 'R0'],  ['status' => 'R0N']]]],
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
		$result = $this->table('aset')->aggregate(
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
	public function getBacksend()
	{
		$result = $this->table('aset')->aggregate(
			[
				['$match' => ['id_aset' => $this->input->post('id_aset')]],
				['$sort' => ['_id' => -1]],
				['$project' => [
					'id_aset' => 1,
					'nama_aset' => 1,
					'code' => 1
				]]
			]
		)->toArray();;
		return $result;
	}
	public function updateBack()
	{
		$result = $this->table('aset')->findOne(['id_aset' => $this->input->post('id_aset')]);
		$iduser = $this->session->userdata('id');
		$set = [
			'id_user_tujuan' => $this->input->post('tujuan'),
			'id_user_asal' => $iduser,
			'deskripsi' => $this->input->post('deskripsi'),
			'status' => "R0"
		];
		$add = $this->table('aset')->updateOne(
			['id_aset' => $this->input->post('id_aset')],
			['$set' => $set]
		);


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
		$this->table('history')->insertOne($data);
		return $add;
	}
	public function delReq()
	{
		$result = $this->table('aset')->findOne(['id_aset' => $this->input->post('id_aset')]);
		if ($result['id_user_tujuan']) {
			$set = [
				'id_user_tujuan' => '',
				'status' => "1"
			];
			$updateResult = $this->table('aset')->updateOne(
				['id_aset' => $this->input->post('id_aset')],
				['$set' => $set]
			);
		} else {
			$updateResult = $this->table('aset')->deleteOne(
				['id_aset' => $this->input->post('id_aset')]
			);
		}
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
		$this->table('history')->insertOne($data);

		return $updateResult;
	}
	public function addReq()
	{
		$resulttmp = $this->table('aset_tmp')->aggregate(
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
		$resultast = $this->table('aset')->aggregate(
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
				'status' => 'R0',
				'date' => date("Y-m-d H:i:s")
			];
			$this->table('aset')->insertOne($data);
			$this->table('history')->insertOne([
				'id_history' =>  $this->mongodb->id(),
				'id_aset' => $data['id_aset'],
				'id_user_asal' => $this->session->userdata('id'),
				'id_user_tujuan' => $this->input->post('tujuan'),
				'id_category' => $this->input->post('kategori'),
				'nama_aset' => $this->input->post('nama'),
				'code' => $this->input->post('code'),
				'status' => 'R0',
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
		$result = $this->table('aset')->aggregate(
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
		$result = $this->table('aset')->findOne(['id_aset' => $this->input->post('id_aset')]);
		$resultast = $this->table('aset')->aggregate(
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
				$this->table('aset')->updateOne(
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
				$this->table('aset')->updateOne(
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
				'status' => $result['status'] . "E",
				'date' => date("Y-m-d H:i:s"),
				'deskripsi' => join(", ", $kol)
			];
			if ($kol) {
				$this->table('history')->insertOne($data);
			}
			$add = ['respon' => 'sukses'];
		} else {
			$add = ['respon' => 'gagal'];
		}

		return $add;
	}
	public function updateReq()
	{
		$result = $this->table('aset')->findOne(['id_aset' => $this->input->post('id_aset')]);
		if ($result['status'] == 'R1N') {
			$result['status'] = 'R1';
		}
		$resultast = $this->table('aset')->aggregate(
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
			$add =  $this->table('aset')->updateOne(
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
			$add = $this->table('aset')->updateOne(
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
		if ($kol) {
			$this->table('history')->insertOne($data);
		}
		return $add;
	}
	public function invtUnc()
	{
		$iduser = $this->session->userdata('id');
		$result = $this->table('aset')->aggregate(
			[
				['$match' => ['id_user_tujuan' => $iduser, 'status' => 'R1']],
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
					'status' => 1,
				]]
			]
		)->toArray();
		return $result;
	}
	public function getUnc($asetid)
	{
		$result = $this->table('aset')->aggregate(
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
		$result = $this->table('aset')->findOne(['id_aset' => $this->input->post('id_aset')]);
		$add = $this->table('aset')->updateOne(
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
		$this->table('history')->insertOne($data);
		$respon = $add->getModifiedCount();
		return $respon;
	}
	public function unDecline()
	{
		$result = $this->table('aset')->findOne(['id_aset' => $this->input->post('id_aset')]);
		$add = $this->table('aset')->updateOne(
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
			'id_user_asal' => $result['id_user_asal'],
			'id_user_tujuan' =>  $result['id_user_tujuan'],
			'id_category' =>  $result['id_category'],
			'nama_aset' =>  $result['nama_aset'],
			'code' => $result['code'],
			'status' => $result['status'] . "N",
			'date' => date("Y-m-d H:i:s"),
		];
		$this->table('history')->insertOne($data);
		$respon = $add->getModifiedCount();
		return $respon;
	}
	public function invtAll()
	{
		$result = $this->table('aset')->aggregate(
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
		$result = $this->table('history')->aggregate(
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
		$result = $this->table('user')->findOne(['username' => $where]);
		return $result;
	}
	function adminno($where)
	{
		$result = $this->table('user')->aggregate(
			[
				['$match' => ['id_admin' => $where]],
				['$project' => ['telp' => 1,]]

			]
		)->toArray();
		return $result;
	}
	public function profile()
	{
		$updateResult = $this->table('user')->findOne(
			['id_admin' => $this->session->userdata('id')]
		);
		return $updateResult;
	}
	public function resetpwd()
	{
		$updateResult = $this->table('user')->updateOne(
			['id_admin' => $this->session->userdata('id')],
			[
				'$set' => [
					'password' => md5($this->input->post('password'))
				]
			]
		);
		return $updateResult;
	}
	public function updateImg()
	{
		$updateResult = $this->table('user')->updateOne(
			['id_admin' => $this->session->userdata('id')],
			[
				'$set' => [
					'img' => $this->input->post('img')
				]
			]
		);
		return $updateResult;
	}
	public function updateProfile()
	{
		if (substr($this->input->post('telp'), 0, 1) == 0) {
			$telpon = '62' . substr($this->input->post('telp'), 1);
		} else {
			$telpon = $this->input->post('telp');
		}
		$validate = $this->session->userdata('id');
		$cekusername = $this->table('user')->findOne(
			['username' => $this->input->post('username')]
		);
		$cektelp = $this->table('user')->findOne(
			['telp' => $telpon]
		);
		$cekemail = $this->table('user')->findOne(
			['email' => $this->input->post('email')]
		);
		if (!$cekemail or $cekemail['id_admin'] == $validate) {
			$cekemail = 1;
		} else {
			$cekemail = 0;
		}
		if (!$cektelp or $cektelp['id_admin'] == $validate) {
			$cektelp = 1;
		} else {
			$cektelp = 0;
		}
		if (!$cekusername or $cekusername['id_admin'] == $validate) {
			$cekusername = 1;
		} else {
			$cekusername = 0;
		}
		if ($cekemail == 1 && $cekusername == 1 && $cektelp == 1) {
			$this->table('user')->updateOne(
				['id_admin' => $this->session->userdata('id')],
				[
					'$set' => [
						'username' => $this->input->post('username'),
						'telp' => $telpon,
						'email' => $this->input->post('email'),
						'nama_Admin' => ucwords($this->input->post('nama_Admin'))
					]
				]
			);
			$updateResult = 1;
		} else {
			$updateResult = ["username" => $cekusername, "email" => $cekemail, "telp" => $cektelp];
		}

		return $updateResult;
	}
	public function reportApi()
	{
		$result = $this->table('history')->aggregate(
			[
				[
					'$match' => [
						'id_user_asal' => $this->session->userdata('id'),
						// '$or' => [
						// 	[
						'status' => ['$nin' => ['R1E', 'R0E', '0E']]
						// ],
						// 	['status' => 'R0']
						// ]
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
					'date' => 1,
					'user_info.nama_Admin' => 1,
					'tujuan_info.nama_Admin' => 1
				]]
			]
		)->toArray();
		return $result;
	}
	public function filter()
	{
		if ($this->input->post('date1') && $this->input->post('date2')) {
			$date = [
				'$gte' => $this->input->post('date1'),
				'$lte' => date('Y-m-d', strtotime($this->input->post('date2') . ' + 1 days'))
			];
		} elseif ($this->input->post('date1')) {
			$date = [
				'$gte' => $this->input->post('date1')
			];
		} elseif ($this->input->post('date2')) {
			$date = [
				'$lte' => date('Y-m-d', strtotime($this->input->post('date2') . ' + 1 days'))
			];
		} else {
			$date = [
				'$gte' => "0000-00-00"
			];
		}
		if ($this->input->post('status')) {
			if ($this->input->post('status') != "N" && $this->input->post('status') != "Y") {
				$status = $this->input->post('status');
			}
			if ($this->input->post('status') == "Y") {
				$status = ['$in' => ['R1Y', 'R0Y']];
			}
			if ($this->input->post('status') == "N") {
				$status = ['$in' => ['R1N', 'R0N']];
			}
		} else {
			$status = ['$nin' => ['R1E', 'R0E']];
		}
		if ($this->input->post('tujuan')) {
			$tujuan = $this->input->post('tujuan');
		} else {
			$tujuan = ['$nin' => [null]];
		}

		$result = $this->table('history')->aggregate(
			[
				[
					'$match' => [
						'id_user_asal' => $this->session->userdata('id'),
						'date' => $date,
						'status' => $status,
						'id_user_tujuan' => $tujuan
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
					'date' => 1,
					'user_info.nama_Admin' => 1,
					'tujuan_info.nama_Admin' => 1
				]]
			]
		)->toArray();
		return $result;
	}
	public function invtSearch($search)
	{

		$result = $this->table('aset')->aggregate(
			[
				[
					'$match' => [
						'$or' => [
							['nama_aset' => ['$regex' => $search, '$options' => 'g']],
							['code' => ['$regex' => $search, '$options' => 'g']]
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
}
