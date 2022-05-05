var edit = function(){
	var code = parseInt($(this).attr('id'));
	var target = $( "#target" ).attr("url") + '/edit/' + $(this).attr('id');	
	if (code != 0){		
		document.location.href = target; 
	}
};

var remove = function(){
	var api = $( "#api" ).attr("url") + '/' + $(this).attr('id');	
	if (confirm("Are you right to delete this product?")){		
		$.ajax({url: api, type: 'DELETE'}).done(function(data){			
			alert("product has been deleted");
			document.location.reload();
		}).fail(function(){
			alert('error');
		});	
	}
};

$(document).ready(function(){
	$("button[class='edit']").click(edit);
	$("button[class='delete']").click(remove);
});
