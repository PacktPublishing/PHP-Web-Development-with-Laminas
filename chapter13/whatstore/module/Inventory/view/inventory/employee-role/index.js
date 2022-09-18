var remove = function(){
	var api = $( "#api" ).attr("url") + '/' + $(this).attr('id');	
	if (confirm("Are you right to remove this role from the employee?")){		
		$.ajax({url: api, type: 'DELETE'}).done(function(data){			
			alert("employee has not this role anymore");
			document.location.reload();
		}).fail(function(){
			alert('error');
		});	
	}
};

$(document).ready(function(){
	$("button[class='delete']").click(remove);
});
