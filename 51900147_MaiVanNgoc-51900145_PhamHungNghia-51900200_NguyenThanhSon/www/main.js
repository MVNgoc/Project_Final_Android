$(document).ready(() => {
	const btn_showlist = $(".btn-showlist");
	const navbar_nav = $(".navbar-nav");

	btn_showlist.on("click", function() {
		navbar_nav.toggleClass("open");
	})

	const btn_register = $(".btn-register-js");
	const notification = $(".notification");
	const notification_success = $(".notification_success");
	btn_register.on("click", function() {
		navbar_nav.classList.remove("close");
	})

	notification.on("click", function() {
		notification.toggleClass("close");
	})

	notification_success.on("click", (event) => {
		event.stopPropagation();
	})
})