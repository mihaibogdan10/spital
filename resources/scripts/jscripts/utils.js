
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
			document.location = 'delete_patient.php?id=' + id;
		else if (what == 'fisa')
			document.location = 'delete_record.php?id=' + id;
	}
}