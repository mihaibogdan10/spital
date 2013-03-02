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

function savePage() {
	$.ajax({
		type: "POST",
		url: "resources/scripts/phpscripts/update_record.php",
		data: { 
			id: $('#record_id').val(),
			investigation_result: CKEDITOR.instances.investigation_result_textarea.getData().trim(),
			investigation: $('#investigation_span').html().trim(),
			sending_medic: $('#sending_medic_input').val().trim(),
			sending_diagnosis: $('#sending_diagnosis_input').val().trim(),
			gamma_room: $('#gamma_room_input').val().trim(),
			radiopharmaceutical_isotope: $('#radiopharmaceutical_isotope_input').val().trim(),
			dose: $('#dose_input').val().trim(),
			collimator: $('#collimator_input').val().trim(),
			clinic: $('#clinic_input').val().trim()
		},
		beforeSend: function () {},
		error: function (e) { 
			console.log(e);
		},
		success: function (e) {
			window.location.replace("patient.php?id=" + patient_id + "#Fisa a fost salvata!");
		}
	});
}

$('#save_result_image').click( savePage );
$('#save_result_text').click( savePage );
