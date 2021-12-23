// ví dụ sử dụng javascript thuần
window.addEventListener("load", () => {
	let title = document.querySelector("h3");

	title.onmouseover = () => {
		title.style.color = "deeppink";
	};

	title.addEventListener("mouseleave", () => {
		title.style.color = "black";
	});
});

// ví dụ sử dụng jquery
$(document).ready(() => {
	$("#test").on("click", () => {
		$("h3").html("jQuery đã hoạt động");
	});
});
