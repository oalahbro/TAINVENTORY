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
        $table = $this->mongodb->table('admin');
        $result = $table->findOne([
            'username' => $where['username'],
            'katasandi' => $where['password']
        ]);
        return $result;
    }
}
