var login = function() {
	var api = $("#api").attr("url");
	var target = $("#target").attr("url");
	var formData = $("#user").serialize();
	$.post(api, formData, function(data) {
		if (!data.logged) {
			alert('Invalid data!');
			return;
		}
		alert("user has been logged successfully");
		window.location.href = target;
	}).fail(function() {
		alert('error');
	});
};

$(document).ready(function() {
	$("#login").click(login);
});