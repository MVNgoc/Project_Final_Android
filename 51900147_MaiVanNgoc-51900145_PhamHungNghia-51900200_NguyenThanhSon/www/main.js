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

	const avatar_placeholder = $("#avatar_placeholder");
	const avatar = $(".avatar");
	avatar_placeholder.on("click", function() {
		avatar.click();
	})

	const btn_submit = $(".btn-submit");
	const btn_placeholder_submit = $(".btn-placeholder-submit");

	btn_placeholder_submit.on("click", function() {
		btn_submit.click();
	})

	const btn_add_manager = $(".btn-add-manager");
	const notification_chooseManager = $(".notification_chooseManager");
	btn_add_manager.on("click", function() {
		notification_chooseManager.toggleClass("open-addmanagerform");
	})

	const notification_exit = $(".notification_exit");
	const chooseManager_form = $(".chooseManager_form");
	notification_exit.on("click", function() {
		notification_chooseManager.toggleClass("open-addmanagerform");
	})

	notification_chooseManager.on("click", function() {
		notification_chooseManager.toggleClass("open-addmanagerform");
	})

	chooseManager_form.on("click", (event) => {
		event.stopPropagation();
	})

})

// function triggerClick() {
// 	document.querySelector('.avatar').click();
// }

function displayImage(e) {
	if(e.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			document.querySelector('#avatar_placeholder').setAttribute('src', e.target.result);
		}
		reader.readAsDataURL(e.files[0]);
	}
}
