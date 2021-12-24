$(document).ready(() => {
    $("#loginForm").submit(e => {
        const username = $("#username").val();
        const pwd = $("#pwd").val();

        if(pwd.length === 0) {
            errorMessage("Please enter your password")
            $("#pwd").focus();
            e.preventDefault();
        }

        if(username.length === 0) {
            errorMessage("Please enter your username")
            $("#username").focus();
            e.preventDefault();
        }   
    })

    $("#username").click(function() {
        errorMessage("")
    })

    $("#pwd").click(function() {
        errorMessage("")
    })

    function errorMessage(err) {
        $("#errorMessage").html(err)
        $("#errorMessage").show()
    }

	const btn_showlist = $(".btn-showlist")
	const navbar_nav = $(".navbar-nav")

	btn_showlist.on("click", function() {
		navbar_nav.toggleClass("open");
	})
})