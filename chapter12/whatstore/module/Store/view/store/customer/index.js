var login = function(){
	var api = $( "#api" ).attr("url") + '/login';
	var target = $( "#target" ).attr("url");	
	var formData = $( "#login" ).serialize();
	var id = $( "#pkey" ).attr("value") 
	$.post( api, formData , function(data){
		if (!data.logged){
			alert('Invalid data!');
			return;
		}			
		alert("customer has been logged");
		window.location.href = target;
	}).fail(function(){
		alert('error');
	});	
};

$(document).ready(function(){
	$("button#login").click(login);
});