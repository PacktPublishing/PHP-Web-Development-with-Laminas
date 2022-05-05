var addToBasket = function(){
	var api = $( "#api" ).attr("url") + '/' + $(this).attr('id');
	var formData = $( "#product" + $(this).attr('id') ).serialize();
	$.post(api, formData).done(function(data){
		var target = $( "#target" ).attr("url");			
		document.location = target;
	}).fail(function(){
		alert('error to insert product into basket');
	});	
};

$(document).ready(function(){
	$("button[class='buy']").click(addToBasket);
});
