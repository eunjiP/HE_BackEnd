<?php
    include_once('header.php');
?>

<div class="container">
    <div class="sec-p">
        <?php if($allResult['result'] !== null) { ?>
            <div class="sec-title">'<?= esc($allResult['searchName'])?>' 의 검색결과 입니다.</div>
                <table id="product-list">
                    <thead>
                        <tr>
                            <th></th>
                            <th>품목명</th>
                            <th>배출 분류</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($allResult['result'] as $row) : ?>
                        <tr>
                            <td class="pd_img"><?= esc($row['productImg'])?></td>
                            <td><?= esc($row['productName'])?></td>
                            <td><?= esc($row['cateName'])?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table> 
            </div>
        <?php } else { ?>
            <div class="sec-title">'<?= esc($allResult['searchName'])?>' 의 검색결과가 없습니다.</div>
            <span>다른 검색어를 입력해보세요.</span>
        <?php } ?>
    </div>
</div>
<?php
    include_once('footer.php');
?>