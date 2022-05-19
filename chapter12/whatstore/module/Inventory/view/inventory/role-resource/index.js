var remove = function(){
	var api = $( "#api" ).attr("url") + '/' + $(this).attr('id');	
	if (confirm("Are you right to remove this permission?")){		
		$.ajax({url: api, type: 'DELETE'}).done(function(data){			
			alert("permisson to this resource has been removed - the effect will occurs in the next login");
			document.location.reload();
		}).fail(function(){
			alert('error');
		});	
	}
};

$(document).ready(function(){
	$("button[class='delete']").click(remove);
});
