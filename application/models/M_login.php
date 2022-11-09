<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function cek($where)
    {
        $table = $this->mongodb->table('user');
        $result = $table->findOne([
            'username' => $where['username'],
            'password' => $where['password']
        ]);
        return $result;
    }
    function addData($data_add)
    {
        $table = $this->mongodb->table('user');
        $add = $table->insertOne([
            'id_admin' => $this->mongodb->id(),
            'nama_Admin' => $data_add['nama_Admin'],
            'username' => $data_add['username'],
            'password' => md5($data_add['password']),
            'level' => $data_add['level'],
            'status' => 0
        ]);
        return $add;
    }
}
