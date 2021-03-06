window.onload = function() {
	var paragraph = document.createElement('p');
	
	paragraph.innerHTML = investigation_result_data;
	if (paragraph.firstChild)
		$('#investigation_result_div').html(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = gamma_room_data;
	if (paragraph.firstChild)
		$('#gamma_room_span').html(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = collimator_data;
	if (paragraph.firstChild)
		$('#collimator_span').html(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = radiopharmaceutical_isotope_data;
	if (paragraph.firstChild)
		$('#radiopharmaceutical_isotope_span').html(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = dose_data;
	if (paragraph.firstChild)
		$('#dose_span').html(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = sending_medic_data;
	if (paragraph.firstChild)
		$('#sending_medic_span').html(paragraph.firstChild.nodeValue);
	paragraph.innerHTML = sending_diagnosis_data;
	if (paragraph.firstChild)
		$('#sending_diagnosis_span').html(paragraph.firstChild.nodeValue);
};

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
});

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
	
    window.print();

    document.body.innerHTML = originalContents;
}