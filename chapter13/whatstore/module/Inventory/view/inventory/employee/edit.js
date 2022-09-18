var save = function(){
	var api = $( "#api" ).attr("url");
	var target = $( "#target" ).attr("url");	
	var formData = $( "#employee" ).serialize();
	var id = parseInt($( "input[name='ID']" ).val());
	if (id == 0){
		$.post( api, formData , function(data){
			if (data.inserted == 'invalid'){
				alert('Invalid data!');
				return;
			}			
			alert("employee has been inserted");
			window.location.href = target;
		}).fail(function(){
			alert('error');
		});	
	} else {		
		api = $( "#api" ).attr("url") + '/' + $(this).attr('id');
		$.ajax({url: api, type: 'PUT', data: formData}).done(function(data){
			if (data.updated == 'invalid'){
				alert('Invalid data!');
				return;
			}			
			alert("employee has been updated");
			window.location.href =  target;
		}).fail(function(){
			alert('error');
		});
	}	
};

$(document).ready(function(){
	$("#save").click(save);
});