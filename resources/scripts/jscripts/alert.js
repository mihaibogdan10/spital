$(document).ready(function () {
	var msg = document.location.hash.substr(1);
	if (msg.length == 0) return ;
	$container = $("#container").notify();
	$("#container").notify("create", {
		title: '',
		text: msg
	});
					
	document.location.hash = "";
});