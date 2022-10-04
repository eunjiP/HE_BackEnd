<?php
    include_once('head.php');
?>
<div>
    검색페이지!
</div>

<div id="search-section">
    <div class="word_sch sec-p">
        <div class="sec-title">검색어로 찾기</div>
        <form method="POST" action="/search/searchProduct" class="input_sch">
            <input type="text" name="productName" placeholder="어떤 품목을 찾으시나요?">
            <button type="submit" class="btn_sch"><i class="icon_sch"></i></button>
        </form>
    </div>

    <div class="rank_sch sec-p ">
        <div class="sec-title" >가장 많이 검색하고 있어요.</div>
        <div class="describeMyself">
            <ul class="descriptionList"><!-- 롤링 효과 -->
                <li>인기검색어1</li>
                <li>인기검색어2</li>
                <li>인기검색어3</li>
                <li>인기검색어4</li>
                <li>인기검색어5</li>
                <li>인기검색어6</li>
                <li>인기검색어7</li>
                <li>인기검색어8</li>
                <li>인기검색어9</li>
                <li>인기검색어10</li>
                <li>인기검색어1</li>
                <li>인기검색어2</li>
                <li>인기검색어3</li>
            </ul>
        </div>
    </div>

    <div class="material_sch sec-p">
        <div class="sec-title"> 분류별 검색 </div>
        <ul>
            <li><img src="/img/material_icon/1.png" alt=""><span>캔류</span></li>
            <li><img src="/img/material_icon/2.png" alt=""><span>멸균팩</span></li>
            <li><img src="/img/material_icon/3.png" alt=""><span>비닐류</span></li>
            <li><img src="/img/material_icon/4.png" alt=""><span>플라스틱</span></li>
            <li><img src="/img/material_icon/5.png" alt=""><span>종이</span></li>
            <li><img src="/img/material_icon/6.png" alt=""><span>종이팩</span></li>
            <li><img src="/img/material_icon/7.png" alt=""><span>페트</span></li>
            <li><img src="/img/material_icon/8.png" alt=""><span>유리</span></li>
            <li><img src="/img/material_icon/9.png" alt=""><span>불가능</span></li>
        </ul>
    </div>
</div>
<?php
    include_once('footer.php');
?>