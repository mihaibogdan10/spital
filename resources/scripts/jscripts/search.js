$('.search').click(function () {
	var show = $('#search_txt').css('display') == 'none';
	switch (show) {
		case true:
			$(this).css('border', '1px solid #F0F0F0');
			$('#search_txt').show();
			$('#search_txt').animate({
				width: '270px'
			}, 500, function () {
				$('#search_txt').focus();
			});
		break;
		
		case false:
			$('#search_results').hide();
			$('#search_txt').animate({
				width: '0px'
			}, 500, function () {
				$('#search_txt').hide();
				$('.search').css('border', '1px solid #FFF');
			});
		break;
	}
});

$('#search_txt').change(function() {
	window.location = 'search.php?q=' + $(this).val();
});
