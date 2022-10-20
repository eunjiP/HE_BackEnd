<div class="menu">
    <button id="btn">
        <span></span><span></span><span></span>
    </button>
    <ul class="sub up one">
        <li class="none">
            <a href=""></a>
        </li>
        <li>
            <a href="#">Q & A</a>
        </li>
        <li>
            <a href="#">지역정보</a>
        </li>
        <li>
            <a href="#">퀴즈</a>
        </li>
    </ul>
</div>

<script>
    const menu = document.querySelector(".menu");
    const subBar = document.querySelector(".menu>.sub");

    let subToggle = true,
        i = 0;

    function slide_menu() {
        if (subToggle) {
            subBar.style.display = "block";
            subBar.classList.remove("up");
            subBar.classList.add("down");
            subToggle = !subToggle;
        } else {
            subBar.classList.remove("down");
            subBar.classList.add("up");
            subToggle = !subToggle;
        }
        console.log(subBar.classList);
    }

    menu.addEventListener("click", slide_menu);

    let e = document.getElementById('btn');
    e.addEventListener('click', function() {
        if (this.className == 'on') this.classList.remove('on');
        else this.classList.add('on');
    });
</script>