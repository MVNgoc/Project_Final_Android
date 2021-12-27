$(document).ready(() => {
	const btn_showlist = $(".btn-showlist");
	const navbar_nav = $(".navbar-nav");

	btn_showlist.on("click", function() {
		navbar_nav.toggleClass("open");
	})

    let countDown = 10;
    let id = setInterval(() => {

        countDown --;
        if (countDown >= 0) {
			const counter = $("#counter");
			counter.html(countDown);
        }
        if (countDown == -1) {
            clearInterval(id);
            window.location.href = 'login.php';
        }
    }, 1000);
})