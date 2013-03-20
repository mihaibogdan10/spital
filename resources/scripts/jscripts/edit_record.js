window.onload = function() {
	var paragraph = document.createElement('p');
	
	paragraph.innerHTML = investigation_result_data;
	if (paragraph.firstChild)
		$('#investigation_result_textarea').val(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = gamma_room_data;
	if (paragraph.firstChild)
		$('#gamma_room_input').val(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = collimator_data;
	if (paragraph.firstChild)
		$('#collimator_input').val(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = radiopharmaceutical_isotope_data;
	if (paragraph.firstChild)
		$('#radiopharmaceutical_isotope_input').val(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = dose_data;
	if (paragraph.firstChild)
		$('#dose_input').val(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = sending_medic_data;
	if (paragraph.firstChild)
		$('#sending_medic_input').val(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = sending_diagnosis_data;
	if (paragraph.firstChild)
		$('#sending_diagnosis_input').val(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = clinic_data;
	if (paragraph.firstChild)
		$('#clinic_input').val(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = investigation_data;
	if (paragraph.firstChild)
		$('#investigation_select').val(paragraph.firstChild.nodeValue);
	
	
	CKEDITOR.replace( 'investigation_result_textarea',{
        on :{
            instanceReady : function( ev ){
				var blockTags = ['div','h1','h2','h3','h4','h5','h6','p','pre','li','blockquote','ul','ol',
								'table','thead','tbody','tfoot','td','th', 'tr', 'br'];
								
                //functie care elimina /n-urile
				// /n-urile sunt evil!!! nu le vrem intr-un textbox in care incarcam ckeditor
				for (var i = 0; i < blockTags.length; i++)
					this.dataProcessor.writer.setRules( blockTags[i],
						{
							indent : false,
							breakBeforeOpen : false,
							breakAfterOpen : false,
							breakBeforeClose : false,
							breakAfterClose : false
						});
            }
        }
    });
};

function showSelect() {
	document.getElementById("investigation_select").style.display = "inline-block";
	$('#investigation_span').hide();
}

$('#investigation_select').change(function () {
	console.log($(this).val());
	$('#investigation_span').html($('#investigation_select').val()).show(); 
	$('#investigation_title').html($('#investigation_select').val()); 
	$('#investigation_select').hide(); 
});

function handleFileSelect(evt) {
	var files = evt.target.files;  // files is a FileList of File objects.

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {
		// Only process image files.
		if (!f.type.match('image.*')) {
			continue;
		}

		var reader = new FileReader();
		
		last_update = f.lastModifiedDate ? new Date(Date.parse(f.lastModifiedDate)) : null;
		day   = last_update ? last_update.getDate() : null;
		month = last_update ? last_update.getMonth() : null;
		year  = last_update ? last_update.getFullYear() : null;
		
		// Closure to capture the file information.
		reader.onload = (function(theFile) {
			return function(e) {
				// Render thumbnail.
				var span = document.createElement('span');
				span.innerHTML = ["<table><tr><td align='center'><img class = 'thumb' src='", 
								e.target.result,"'></td><td>", 
								'<ul><li><strong>', escape(theFile.name), '</strong> (', theFile.type || 'n/a', ')</li>',
								'<li>', theFile.size, ' bytes </li>',
								'<li> ultima actualizare: ', theFile.lastModifiedDate ? day + '.' + (month + 1) + '.' + year: 'n/a', '</li>',
								"</ul></td></tr></table>"].join('');
				document.getElementById('list_files').insertBefore(span, null);
			};
		})(f);

		// Read in the image file as a data URL.
		reader.readAsDataURL(f);
    }
}

if (window.File && window.FileReader && window.FileList && window.Blob) {
	// Great success! All the File APIs are supported.
	document.getElementById('upload_files[]').addEventListener('change', handleFileSelect, false);
}
else {
	alert('The File APIs are not fully supported in this browser.');
}

// select the target node
target = document.getElementById('imgUploadFrame').contentWindow.document.body;

$(document).ready(function(){
	//Button helper. Disable animations, hide close button, change title type and content
	$('.fancybox-buttons').fancybox({
		openEffect  : 'none',
		closeEffect : 'none',
		prevEffect : 'none',
		nextEffect : 'none',

		closeBtn  : false,
		helpers : {
			title : {
				type : 'inside'
			},
			buttons	: {}
			},
			afterLoad : function() {
			this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
		}
	});
	
	//upload done listener
	$('#imgUploadFrame').load(function() {
		$('#list_files').html($(this).contents().find('body').html());
		if ($('#list_files').html().indexOf("a fost atasata") >= 0)
			$('#list_files').html($('#list_files').html() + "Pentru a le vedea dati refresh la pagina. Nu uitati sa salvati in prealabil daca ati facut modificari.");
    });
	
	//prepare tag input
	$('#tag_input').autocomplete({
		source: [
			'gusa nodulara', 'adenom', 'fara noduli', 'tiroidita', 'boala Basedow', 'neoplasm tiroidian', 'carcinom', 'MTS',
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
			'stern', 'vertebral', 'coaste', 'bazin', 'oase lungi',
		],
		
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
	});
});


function deleteImage(record_id, name) {
	if (confirm("Esti sigur ca vrei sa stergi aceasta imagine?"))
		document.location = 'resources/scripts/phpscripts/delete_image.php?record_id=' + record_id + '&image_name=' + name;
}