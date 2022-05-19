var save = function(){
	var api = $( "#api" ).attr("url");
	var target = $( "#target" ).attr("url");	
	var formData = $( "#resources_role" ).serialize();
	$.post( api, formData , function(data){
		if (data.inserted == 'invalid'){
			alert('Invalid data!');
			return;
		}			
		alert("permission has been granted");
		window.location.href = target;
	}).fail(function(){
		alert('error');
	});	
};

$(document).ready(function(){
	$("#save").click(save);
});