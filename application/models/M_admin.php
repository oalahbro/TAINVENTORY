<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
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
	public function getCategory()
	{
		$result = $this->table('category')->find(['status' => '1'])->toArray();
		return $result;
	}
	public function getTuser()
	{
		$table = $this->table('user');
		$result = $table->find(['$or' => [
			['level' => '3'],
			['level' => '2'],
			['level' => '1']
		], 'status' => '1'])->toArray();
		return $result;
	}

	public function getInventory()
	{
		$result = $this->table('aset')->find()->toArray();
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
				'status' => $result['status'] . "E ",
				'date' => date("Y-m-d H:i:s"),
				'deskripsi' => join(", ", $kol)
			];
			$this->table('history')->insertOne($data);
			$add = ['respon' => 'sukses'];
		} else {
			$add = ['respon' => 'gagal'];
		}

		return $add;
	}
	public function updateReq()
	{
		$result = $this->table('aset')->findOne(['id_aset' => $this->input->post('id_aset')]);
		if (!$this->input->post('img')) {
			$resultast = $this->table('aset')->aggregate(
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
			$this->table('history')->insertOne($data);
			$add =  $this->table('aset')->updateOne(
				['id_aset' => $this->input->post('id_aset')],
				[
					'$set' => $noimg
				]
			);
		} else {
			$add = $this->table('aset')->updateOne(
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
	public function delReq()
	{
		$result = $this->table('aset')->findOne(['id_aset' => $this->input->post('id_aset')]);
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

		$updateResult = $this->table('aset')->deleteOne(
			['id_aset' => $this->input->post('id_aset')]
		);
		return $updateResult;
	}
	public function invtTmp()
	{
		$iduser = $this->session->userdata('id');
		$table = $this->table('aset_tmp');
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
			$cektuj = $this->table('user')->findOne(['id_admin' => $this->input->post('tujuan')]);
			if ($cektuj['level'] !== '3') {
				$stts = 'R1';
			} else {
				$stts = 'R0';
			}
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
				'status' => $stts
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
	public function delTmp()
	{
		$updateResult = $this->table('aset_tmp')->deleteOne(
			['id_aset_tmp' => $this->input->post('id_aset_tmp')]
		);
		return $updateResult;
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
	public function invtAll()
	{
		$result = $this->table('aset')->aggregate(
			[
				[
					'$match' => [
						'$or' => [
							['status' => '1'],
							['status' => '0']
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
	public function updateBack()
	{
		$resultusr = $this->table('user')->findOne(['id_admin' => $this->input->post('tujuan')]);
		$result = $this->table('aset')->findOne(['id_aset' => $this->input->post('id_aset')]);
		$iduser = $this->session->userdata('id');

		if ($resultusr['level'] == 2) {
			$set = [
				'id_user_tujuan' => $this->input->post('tujuan'),
				'id_user_asal' => $iduser,
				'deskripsi' => $this->input->post('deskripsi'),
				'status' => "R1"
			];
			$add = $this->table('aset')->updateOne(
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
			$add = $this->table('aset')->updateOne(
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
		$this->table('history')->insertOne($data);
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
	public function addReq()
	{
		$history = $this->table('history');
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
			$user = $this->table('user');
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
				$this->table('aset')->insertOne($data);
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
				$this->table('aset')->insertOne($data);
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
		$this->table('history')->insertOne($data);
		$respon = $add->getModifiedCount();
		return $respon;
	}
	public function getAdmin()
	{
		$result = $this->table('user')->find()->toArray();
		return $result;
	}
	public function getCategoryall()
	{
		$result = $this->table('category')->find()->toArray();
		return $result;
	}

	public function add($datanya)
	{
		$tambah = $this->table('aset')->insertOne($datanya);
		return $tambah;
	}
	public function invtUnc()
	{
		$iduser = $this->session->userdata('id');
		$result = $this->table('aset')->aggregate(
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
	function addAdmin($data_add)
	{
		$add = $this->table('admin')->insertOne([
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
		$result = $this->table('user')->findOne(['username' => $where]);
		return $result;
	}

	function addCategory($data_add)
	{
		$add = $this->table('category')->insertOne([
			'id_kategori' => $this->mongodb->id(),
			'nama_kategori' => $data_add['nama_kategori'],
			'status' => $data_add['status']
		]);
		return $add;
	}


	public function updateCat($datanya)
	{
		$updateResult = $this->table('category')->updateOne(
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
		$updateResult = $this->table('category')->deleteOne(
			['id_kategori' => $datanya['id_kategori']]
		);
		return $updateResult;
	}
}
