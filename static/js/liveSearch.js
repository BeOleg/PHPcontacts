(function(){
	$(function(){
		 function updateFn(self){
		 	$.get('/API/' + $(self).attr('data-type'), { 'search': $(self).val(), 'uid': $(self).attr('data-user-id'), 'days': $('#daysRange').val()}, 
		 		function(data){
		 			$("#blockContent").html(data);
		 		});	
		 }
		$("#query_string").keyup(function(){	
			updateFn(this);

		});
		$("#daysRange").on('change', function(){
			updateFn($("#query_string"));
		});

	});
})();