$(function () {			
	$('#passwordForm').validate({
		rules: {
			nume: "required",
			prenume: "required",
			parola: { required: "#psc:checked", minlength: function() {
																if ($('#psc').prop('checked')) 
																	return 6;
																else 
																	return 0; 
															} },
			parola1: { required: "#psc:checked", minlength: function() {
																if ($('#psc').prop('checked')) 
																	return 6;
																else 
																	return 0; 
															} },
			parola2: { equalTo: "#parola1" }
		},
		messages: {
			nume: "Numele este obligatoriu",
			prenume: "Prenumele este obligatoriu",
			parola: {
				required: "Introduceti parola veche",
				minlength: jQuery.format("Introduceti parola veche"),
			},
			parola1: {
				required: "Introduceti noua parola",
				minlength: jQuery.format("Introduceti minim {0} caractere")
			},
			parola2: { equalTo: "Parolele nu coincid" }
		}
	});

	$('#loginForm').validate({
		rules: {
			email: { required: true, email: true },
			parola: { required: true, minlength: 6 }
		}, 
		messages: {
			email: {
				required: "Adresa de e-mail este necesara",
				email: "Adresa de e-mail nu este corecta"
			},
			parola: {
				required: "Parola este necesara",
				minlength: jQuery.format("Parola trebuie sa contina minim {0} caractere"),
			}
		}
	});
	
	$('#registerForm').validate({
		rules: {
			nume: "required",
			prenume: "required",
			email: { required: true, email: true },
			parola1: { required: true, minlength: 6 },
			parola2: { equalTo: "#parola1" },
			tos: "required"
		},
		messages: {
			nume: "Numele este obligatoriu",
			prenume: "Prenumele este obligatoriu",
			email: {
				required: "Adresa de e-mail este necesara",
				email: "Adresa de e-mail nu este corecta"
			},
			parola1: {
				required: "Parola este obligatorie",
				minlength: jQuery.format("Introdu minim {0} caractere")
			},
			parola2: { equalTo: "Parolele nu coincid" },
			tos: "Campul trebuie bifat"
		}
	});
});