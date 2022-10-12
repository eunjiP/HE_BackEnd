<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class SearchModel extends Model{

        public $db;
    
        public function __construct()
        {
            $this->db = \Config\Database::connect("default", false);
        }
    
        public function getProduct($data) {
            $search = $data['productName'];

            $sql = 
            "SELECT A.i_product, A.productName, A.productImg, B.cateName FROM product A
             INNER JOIN cate B
                     ON A.i_cate = B.i_cate
                  WHERE productName LIKE '%".$search."%'
                     OR B.cateName LIKE '%".$search."%'
            ";
            return $this->db->query($sql)->getResultArray();
        }

        public function getCate() {
            $sql = "SELECT * FROM cate";
            return $this->db->query($sql)->getResultArray();
        }
    
    }
