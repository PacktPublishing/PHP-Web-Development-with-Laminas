var save = function(){
	var api = $( "#api" ).attr("url");
	var target = $( "#target" ).attr("url");	
	var formData = $( "#product" ).serialize();
	var code = parseInt($( "input[name='code_product']" ).val());
	api = $( "#api" ).attr("url") + '/' + code;
	$.ajax({url: api, type: 'PUT', data: formData}).done(function(data){
		if (data.updated == 'invalid'){
			alert('Invalid data!');
			return;
		}			
		alert("inventory has been updated");
		window.location.href =  target;
	}).fail(function(){
		alert('error');
	});
};

$(document).ready(function(){
	$("#save").click(save);
});