var closeOrder = function(){
	var api = $( "#api" ).attr("url") + '/0';
	var target = $( "#target" ).attr("url");
	$.post(api).done(function(data){
		if (!data.inserted)
		{
			alert('purchase order has been not inserted!');
			return;	
		}
		alert('Thank you for buying in Whatstore! Come back always!')
		document.location = target;
	}).fail(function(){
		alert('error to close the purchase order');
	});	
};

$(document).ready(function(){
	$("#close").click(closeOrder);
});
