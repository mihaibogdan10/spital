$('#psc').click(function () {
	var show = $('#psc').prop('checked');
	switch (show) {
		case true:
			$('.passLines').show();
			
			$('#passText').fadeOut(200, function() {
				$(this).text('Parola veche:').fadeIn(300);
			});

			try {
				texts.passwordRequiredText = "Introduceti parola veche";
			}
			catch(err) {
				console.log(err.message);
			}
			
			$('.passLines')
 				.find('td')
				.wrapInner('<div style="display: none;" />')
				.parent()
				.find('td > div')
				.slideDown(500, function(){

					var $set = $(this);
					$set.replaceWith($set.contents());

			});
		break;
		
		case false:

			$('#passText').fadeOut(200, function() {
				$(this).text('Parola:').fadeIn(300);
			});

			try {
				texts.passwordRequiredText = "Introduceti parola";
			}
			catch(err) {
				console.log(err.message);
			}
			
			$('.passLines')
				.find('td')
				.wrapInner('<div style="display: block;" />')
				.parent()
				.find('td > div')
				.slideUp(500, function(){

					var $set = $(this);
					$set.replaceWith($set.contents());
					$('.passLines').hide();
			 	});
		break;
	}
});



//$('#search_txt').change(function() {
//	window.location = 'search.php?q=' + $(this).val();
