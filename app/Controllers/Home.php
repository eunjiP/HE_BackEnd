<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $db = db_connect();
        $data = [];
        $builder = $db->table('test');
        $data['test']  = $builder->get();
        return view('test', $data);
    }
}
