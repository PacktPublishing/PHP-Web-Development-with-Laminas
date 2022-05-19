var save = function(){
	var api = $( "#api" ).attr("url");
	var target = $( "#target" ).attr("url");	
	var formData = $( "#customer" ).serialize();
	var id = $( "#pkey" ).attr("value") 
	$.post( api, formData , function(data){
		if (data.inserted == 'invalid'){
			alert('Invalid data!');
			return;
		}			
		alert("customer has been inserted");
		window.location.href = target;
	}).fail(function(){
		alert('error');
	});	
};

$(document).ready(function(){
	$("#save").click(save);
});