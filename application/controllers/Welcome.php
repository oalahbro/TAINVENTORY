<?php
defined('BASEPATH') or exit('No direct script access allowed');

class welcome extends CI_Controller
{
    public function index()
    {
        $arr = [
            [
                'nama' => 'sumanto',
                'deskripsi' => 'loremipsum'
            ],
            [
                'nama' => 'sumanto',
                'deskripsi' => 'loremipsum'
            ],
            [
                'nama' => 'sumanto',
                'deskripsi' => 'loremipsum'
            ]
        ];
        return view('blade/index', ['post' => $arr]);
    }
}
