<?php

namespace App\Controllers;
use App\Models\SearchModel;

class Search extends BaseController
{
    public function search()//라우터 경로에 들어갈 함수명
    {   
        $searchModel = new SearchModel(); // 모델 객체 생성
        
        $result = $searchModel->getCate(); //카테고리
        return view('search_page.php', [ 'result' => $result ]);
    }

    /**품목명,분류명으로 검색하면 결과를 가져오는 함수 */
    public function searchProduct() {

        $searchModel = new SearchModel(); // 모델 객체 생성
        $data = $this->request->getPost();// search_page의 form에서 받아온 데이터

        $result = $searchModel->getProduct($data);
        $searchName = $data['productName'];
        $allResult = [
            'result' => $result,
            'searchName' => $searchName
        ];

        if(isset($result[0]['i_product'])) {
            return view('searchResult.php', [ 'allResult' => $allResult ]);
        } else {
            $allResult['result'] = NULL;
            return view('searchResult.php', [ 'allResult' => $allResult ]);
        }
        
    }

}
