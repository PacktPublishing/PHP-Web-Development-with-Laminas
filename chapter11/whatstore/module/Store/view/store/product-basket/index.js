var addOneToAmount = function(){
	var api = $( "#api" ).attr("url") + '/' + $(this).attr('id');
	var target = $( "#target" ).attr("url");	
	$.ajax({url: api, type: 'PUT', data: {'operation': 'add'}}).done(function(data){
		if (!data.updated){
			alert('product has not been updated!');
			return;
		}			
		alert("product amount has been updated");
		window.location.href =  target;
	}).fail(function(){
		alert('error');
	});
};

var subOneFromAmount = function(){
	var api = $( "#api" ).attr("url") + '/' + $(this).attr('id');
	var target = $( "#target" ).attr("url");	
	$.ajax({url: api, type: 'PUT', data: {'operation': 'sub'}}).done(function(data){
		if (!data.updated){
			alert('product has not been updated!');
			return;
		}			
		alert("product amount has been updated");
		window.location.href =  target;
	}).fail(function(){
		alert('error');
	});
};

var deleteProduct = function(){
	var api = $( "#api" ).attr("url") + '/' + $(this).attr('id');
	var target = $( "#target" ).attr("url");	
	$.ajax({url: api, type: 'DELETE'}).done(function(data){
		if (!data.deleted){
			alert('product has not been deleted!');
			return;
		}			
		alert("product has been deleted");
		window.location.href =  target;
	}).fail(function(){
		alert('error');
	});
};

$(document).ready(function(){
	$("button[class='add']").click(addOneToAmount);
	$("button[class='sub']").click(subOneFromAmount);
	$("button[class='delete']").click(deleteProduct);
});
