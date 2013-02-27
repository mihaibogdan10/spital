// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.

function drawInvestigationChart(osoase_no, tiroide_no, paratiroidiene_no, hepatice_no, renale_no, pulmonare_no, cord_no, diverse_no) {
	// Create the data table.
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Tipul');
	data.addColumn('number', 'Numarul de cazuri');
	data.addRows([
		['Osoase(' + osoase_no + ')', osoase_no],
		['Tiroide(' + tiroide_no + ')', tiroide_no],
		['Paratiroide(' + paratiroidiene_no + ')', paratiroidiene_no],
		['Hepatice(' + hepatice_no + ')', hepatice_no],
		['Renale(' + renale_no + ')', renale_no],
		['Pulmonare(' + pulmonare_no + ')', pulmonare_no],
		['Cord(' + cord_no + ')', cord_no],
		['Diverse(' + diverse_no + ')', diverse_no]
	]);

	// Set chart options
	var options = {'title':'Tipuri de investigatii',
		'width':450,
		'height':300,
		'is3D':true
	};
	
	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
	chart.draw(data, options);
}	

$( "#slider_age" ).slider({
	range: true,
	min: 0,
	max: 150,
	values: [ 0, 150 ],
	slide: function( event, ui ) {
		$( "#age_span" ).html( ui.values[0] + " ani - " + ui.values[ 1 ] + " ani " );
	}
});

$( "#age_span" ).html( $( "#slider_age" ).slider( "values", 0 ) + " ani - " + $( "#slider_age" ).slider( "values", 1 ) + " ani " );

// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});
	
// Set a callback to run when the Google Visualization API is loaded.
//google.setOnLoadCallback(drawChart);

$("#query_button").click(function(){
	$.ajax({
		type: "POST",
		url: "statistics_query.php",
		datatype: 'json',
		data: { 
			sex: $("#sex_select").val(),
			age_range: $('#age_span').html().trim(),
		},
		beforeSend: function () {},
		error: function (e) { 
			console.log(e);
		},
		success: function (data) {
			console.log(data);
			data = JSON.parse(data);
			drawInvestigationChart(data["scintigrama_osoasa"], data["scintigrama_tiroidiana"], data["scintigrama_paratiroidiana"],
						data["scintigrama_hepatica"], data["scintigrama_renala"], data["scintigrama_pulmonara"], data["scintigrama_de_cord"], data["diverse"]);
		}
	});
});