<?php
    include_once('header.php');
?>
<div class="container">
    <div class="main__img">
        <div class="main__textBox">
            <div class="main__text">
                <!--<div class="text__icon"><img src="img/main_icon/wastebasket.png" style="height:96px"></div>-->
                <div class="fs-1">오늘은</div>
                <div class="fs-1 bold">" 투명페트병 / 비닐류 "</div>
                <div class="fs-1">배출일 입니다.</div>
                <div class="fs-6">배출시간 : </div>
            </div>
            <div class="main__icon">
                <a href="#">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div  class="modal fade" id="locationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center mt-3">
                <h5 class="modal-title bold">현재 위치를 설정하시겠습니까?</h5>
            </div>
            <div class="_modal_item text-center mb-3">
                <button class="locationBtn">확인</button>
                <button class="locationBtn" data-bs-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>
<?php
    include_once('footer.php');
?>