function isNumberKey(event) {
	const charCode = event.which ? event.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}

	return true;
}

function number_format(val) {
	var options = {
		style: "decimal",
		minimumFractionDigits: 0,
		maximumFractionDigits: 4,
		useGrouping: true, // true untuk menggunakan pemisah ribuan
	};
	return val.toLocaleString("en-US", options);
}
