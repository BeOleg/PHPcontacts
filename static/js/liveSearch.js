(function(){
	$(function(){
		$("#query_string").keyup(function(){	
			$.get('/API/' + $(this).attr('data-type'), { 'search': $(this).val()}, 
				function(data){
					$("#blockContent").html(data);
				});	
		});
	});
})();