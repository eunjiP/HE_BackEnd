<?php
/**************************************************
* Home Controller 
* Create Date: 2022.10.08
* 박은지
**************************************************/

namespace App\Controllers;

class Home extends BaseController
{
    public $data = array();
    public $db;

    //DB연결 생성지
    public function __construct() {
        $this->db = \Config\Database::connect("default", false);
    }

    public function index()
    {
        return view('main.php');
    }

    
}
