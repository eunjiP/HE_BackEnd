<?php

namespace App\Controllers;
use App\Models\SearchModel;

class Search extends BaseController
{
    public function search()//라우터 경로에 들어갈 함수명
    {
        return view('search_page.php');//띄울 view파일명
    }

    // 검색결과 없을 경우의 분기문 만들기
    public function searchProduct() {

        $searchModel = new SearchModel(); // 모델 객체 생성
        $data = $this->request->getPost();// search_page의 form에서 받아온 데이터
        //var_export($data);
        $result = $searchModel->getProduct($data);
        $result['searchName'] = $data['productName'];

        if(isset($result['i_product'])) {
            return view('searchResult.php', $result);
        } else {
            $result['i_product'] = NULL;
            return view('searchResult.php', $result);
        }
        
        // var_export($result);
        
    }
}
