
function checkCNP(cnp) {
    var month = (cnp[3] - '0') * 10 + (cnp[4] - '0');
    if (!(month >= 1 && month <= 12)) return false;

    var day = (cnp[5] - '0') * 10 + (cnp[6] - '0');
    if (!(day >= 1 && day <= 31)) return false;

    var suma = parseInt(cnp[0]) * 2 + parseInt(cnp[1]) * 7 + 
				parseInt(cnp[2]) * 9 + parseInt(cnp[3]) * 1 + 
				parseInt(cnp[4]) * 4 + parseInt(cnp[5]) * 6 + 
				parseInt(cnp[6]) * 3 + parseInt(cnp[7]) * 5 + 
				parseInt(cnp[8]) * 8 + parseInt(cnp[9]) * 2 + 
				parseInt(cnp[10]) * 7 + parseInt(cnp[11]) * 9;
    var rest = suma % 11;

    var valid = false;
    if ((rest < 10) && (rest == cnp[12]) || (rest == 10) && (cnp[12] == '1'))
        valid = true;
    return valid;
}

function deleteObject(what, id) {
	var m = confirm("Esti sigur ca vrei sa stergi " + what + "?");
	if (m) {
		if (what == 'pacientul')
			document.location = 'resources/scripts/phpscripts/delete_patient.php?id=' + id;
		else if (what == 'fisa')
			document.location = 'resources/scripts/phpscripts/delete_record.php?id=' + id;
	}
}

function initializeTagging(){
	$('#tag_input').autocomplete({
		source: function(request, response) {
			tags_array = ['gusa nodulara', 'adenom', 'fara noduli', 'tiroidita', 'boala Basedow', 'neoplasm tiroidian', 'carcinom', 'MTS',
				'nodul unic', 'gusa multinodulara',
				'afixator', 'hiperfixator', 'hipofixator', 'hipo-afixator',
				'hiperfixare difuza', 'hipofixare difuza',
				'omogen', 'eterogen',
				'ectopic',
				'piramida Lalouette',
				'postoperator',
				
				'feminin (F)', 'masculin (M)',
				'sub tratament', 'fara tratament',
				'99mTc', 'MIBI', 'Tetrofosmin', '131I',
				'SPECT', 'corp intreg', 'OAD', 'OAS',
				
				'metastaza unica', 'metastaze multiple',
				'osteolitic', 'osteocondensant',
				'fara metastaze',
				'eterogenitate',
				'punct de plecare neprecizat',
				'stern', 'vertebral', 'coaste', 'bazin', 'femur', 'humerus', 'articulatii', 'craniu', 'omoplat',
				'cancer', 'neoplasm mamar', 'prostata', 'tiroidian', 'uterin', 'renal', 'pulmonar', 'MTS', 'diseminari secundare', 'Paget', 'osteomielita', 'sacroileita', 'osteoporoza',
				'comparativ',
				'in evolutie',
				
				'Medronate', 'HDP', 'MDP', 'MIBI', 'Tetrofosmin',
				'SPECT', 'corp intreg', 'os 3 faze', 'precoce', 'tardiv',
				'stern', 'vertebral', 'coaste', 'bazin', 'oase lungi']
				
			var results = $.ui.autocomplete.filter(tags_array, request.term);
			//limits the tags results to a maximum of 5
			response(results.slice(0, 5));
		},
		
		//define select handler  
		select: function(e, ui) {  
						  
			//create formatted tag  
			var tag = ui.item.value, 
				span = $('<span class="tag">').text(tag),  
				a = $("<a>").addClass("remove").attr({  
					href: "javascript:",  
					title: "Remove " + tag  
				}).text("x").appendTo(span);
				
				// add tag, after input
				$('#tags').append(span);
				$('#tags_hidden').val($('#tags_hidden').val() + (',' + tag + ','));
				$('#tag_input').val('');
				//trigger onchange event
				$('#tags_hidden').trigger('change');
				
				// remove default behaviour (that is, writing the selected value in the input bar)
				return false;
			},  
					  
		//define select handler  
		change: function() {  
					  
			//prevent 'to' field being updated and correct position  
			$("#tag_input").val("").css("top", 2);  
		}  
	});
					  
	//add live handler for clicks on remove links  
	$('body').on('click', 'span .remove', function(){
		//remove current tag  
		
		var tag = $(this).parent().text();
		tag = tag.substr(0, tag.length - 1)
		
		var tags = $('#tags_hidden').val();
		tags = tags.replace(',' + tag + ',', '');
		
		$('#tags_hidden').val(tags);
		$(this).parent().remove();
						  
		//correct 'to' field position  
		if($("#tags span").length === 0) {  
			$("#tag_input").css("top", 0);  
		}                 

		//trigger onchange event
		$('#tags_hidden').trigger('change');
	});
}