<?php

namespace App\Controllers;
use App\Models\SearchModel;

class Search extends BaseController
{
    public function search()
    {
        return view('search_page.php');
    }

    // 검색결과 없을 경우의 분기문 만들기
    public function searchProduct() {

        $searchModel = new SearchModel(); // 모델 객체 생성
        $data = $this->request->getPost();// search_page의 form에서 받아온 데이터
        
        $result = $searchModel->getProduct($data);
        /*
            $result[ i_product => '1', productName => '라면봉지', ctnt => '재활용' ... ]
        */
        // var_export($result);
        return view('searchResult.php', $result);
        
    }
}
