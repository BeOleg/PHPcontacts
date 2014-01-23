(function(){
	function footer(){
		// alert('here');
		var fh = $('footer').height();
		var nh = $('.nav').height();
		var top = $(document).height() > $(window).height() ? $(document).height() -  fh : $(window).height() - fh;//1 is the safety pixel
		$('footer').css('top', top + 'px');

		var mainFrameHeight = $(window).height() - fh - nh;
		$('.mainFrame').css('min-height', mainFrameHeight + 'px');
		$('.jumbotron').css('min-height', mainFrameHeight + 'px');

	}

	$(window).on('load', footer);
	$(window).on('resize', footer);
})();
