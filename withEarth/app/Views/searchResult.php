<?php
    include_once('header.php');
?>

<div class="container">
    <div class="sec-p">
        <?php if($i_product !== NULL) { ?>
        <div class="sec-title">'<?= esc($searchName) ?>'의 검색결과 입니다.</div>  
            <table id="product-list">
                <thead>
                    <tr>
                        <th></th>
                        <th>품목명</th>
                        <th>배출 분류</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="pd_img"><?= esc($productImg)?></td>
                        <td><?= esc($productName)?></td>
                        <td><?= esc($ctnt)?></td>
                    </tr>
                </tbody>
            </table> 
        </div>
        <?php } else { ?>
            <div class="sec-title-null">'<?=esc($searchName)?>'의 검색결과가 없습니다.</div>
        <?php } ?>
    </div>
</div>
<?php
    include_once('footer.php');
?>