$('#forgot').click(function () {

		$('#loginDiv').slideUp(500, function() {
				$('#passDiv').fadeIn(500);
			});
		$('#registerDiv').slideUp(500, function() {
				$('#registerTitle').text('\u00a0');
				$('#registerForm').hide();
				$('#registerDiv').fadeIn(500);
			});
});



//$('#search_txt').change(function() {
//	window.location = 'search.php?q=' + $(this).val();
