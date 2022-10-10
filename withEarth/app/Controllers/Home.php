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

    public function index()
    {
        return view('main.php');
    }

    
}
