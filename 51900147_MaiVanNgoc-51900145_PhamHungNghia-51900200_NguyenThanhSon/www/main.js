$(document).ready(() => {
	const btn_showlist = $(".btn-showlist");
	const navbar_nav = $(".navbar-nav");

	btn_showlist.on("click", function() {
		navbar_nav.toggleClass("open");
	})
})