<?php
    include_once('head.php');
?>
<div>
    검색결과 페이지
</div>

<div class="sec-p">
    <div class="sec-title">'<?= esc($productName) ?>'의 검색결과 입니다.</div>
    <!-- 컨트롤러에서 경로와 함께 보내준 배열의 키값을 직접선언 -->

    <table id="product-list">
        <thead>
            <tr>
                <th></th>
                <th>품목명</th>
                <th>배출 분류</th>
            </tr>
        </thead>

        <tbody><!-- 품목리스트 반복문 돌리기 -->
            <tr>
                <td class="pd_img"><?= esc($productImg)?></td>
                <td><?= esc($productName)?></td>
                <td><?= esc($ctnt)?></td>
            </tr>
        </tbody>
    </table>
    </div>

<?php
    include_once('footer.php');
?>