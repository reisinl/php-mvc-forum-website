var onoff = true
var confirm = document.getElementsByClassName("confirm");
var signCnt = 0;
var signupCnt = 0;

function signIn() {
	doLogin("/SignIn/signin");
}

function logIn() {
	doLogin("/login/login");
}

function doLogin (url) {
	removeErrorMsg();
	let loginForm = document.getElementById("login-form");
	loginForm.submit();
}

function removeErrorMsg () {
	let loginForm = document.getElementById("msg");
	loginForm.innerHTML = "";

}
function setConfirmStyle(height) {
	for (var index = 0; index < confirm.length; index++) {
		confirm[index].style.height = height + "px";
	}
}

function sortPost (obj, item) {
	let order = 'asc';
	let arrow = $(obj).find(".arrow");
	if (arrow.hasClass('asc')) {
		arrow.removeClass("asc");
		arrow.addClass("dsc");
		order = "desc";
	} else if ($(arrow).hasClass('dsc')) {
		arrow.removeClass("dsc");
		arrow.addClass("asc");
		order = "asc";
	} else {
		arrow.addClass("asc");
	}

	$(obj).parent().siblings().find(".arrow").each(function(item, ele){
		$(ele).removeClass("dsc");
		$(ele).removeClass("asc");
	});

	$("#post-form").attr("action", "/home/Order?" + order + "&" + item);
	$("#post-form").submit();
}

function deleteConfirm (id) {
	$.confirm({
		columnClass: 'small',
		title: 'Delete Post',

		content: 'Are you sure to delete this post?',
		autoClose: 'cancelAction|100000',
		escapeKey: 'cancelAction',
		buttons: {
			confirm: {
				btnClass: 'btn-red',
				text: 'Delete',
				action: function(){
					$("form").attr("action", "/post/delete?" + id);
					$("form").submit();
					$.alert('You deleted this account');
				}
			},
			cancelAction: {
				text: 'Cancel',
				action: function(){
					return;
				}
			}
		}
	});
}

function switchLanguage(lang) {
	$.post(
		"/func/switchLan?"+lang
	);
	setTimeout(function(){
		let action = $("#lang-form").attr("action");
		let isLogin = $("#door")[0];


		action.replace("#","");
		$("#lang-form").attr("action",action);
		if (isLogin != undefined) {
			$("#login-form").submit();
		} else {
			$("#lang-form").submit();
		}

	}, 2000);
}

$(function(){
	var at_config = {
		at: "@",
		data: "/func/users",
		headerTpl: '<div class="atwho-header">Member List<small>↑&nbsp;↓&nbsp;</small></div>',
		insertTpl: '@${name}',
		displayTpl: "<li>${name}</li>",
		limit: 200
	}

	$inputor = $('#inputor').atwho(at_config);
	$inputor.focus().atwho('run');
	// remove localStorage
	localStorage.removeItem("auto_saved_sql");
})


