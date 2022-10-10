<?php
    include_once('header.php');
?>

<div class="container">
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
        <ul class="material_list">
            <?php foreach($result as $li) :?>
                <li><img src="/img/material_icon/<?= esc($li['i_cate'])?>.png" alt=""><span><?= esc($li['cateName'])?></span></li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
<?php
    include_once('footer.php');
?>