<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class SearchModel extends Model {

        protected $table = 'product';

        public function getProduct($data) {
            return $this->where(['productName'=>$data])->first();
            // 테스트로 하나만 가져왔음. 목록을 가져올땐 findAll
        }
    }