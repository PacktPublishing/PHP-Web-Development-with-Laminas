var save = function(){
	var api = $( "#api" ).attr("url");
	var target = $( "#target" ).attr("url");	
	var formData = $( "#roles_employee" ).serialize();
	$.post( api, formData , function(data){
		if (data.inserted == 'invalid'){
			alert('Invalid data!');
			return;
		}			
		alert("role has been added");
		window.location.href = target;
	}).fail(function(){
		alert('error');
	});	
};

$(document).ready(function(){
	$("#save").click(save);
});