function check_form() {
	// define all required variables
	var first_name = document.forms["contact"].first_name.value,
		last_name = document.forms["contact"].last_name.value,
		address = document.forms["contact"].address.value,
		phone = document.forms["contact"].phone.value,
		inquiry = document.forms["contact"].inquiry.value,
		error_message = "",
		passed = true;

	error_message += validate("first name", first_name, [3, 10]);
	error_message += validate("last name", last_name, [2, 15]);
	error_message += validate("address", address, [8, 25], false);
	error_message += validate("phone", phone, [10, 10]);
	error_message += validate("inquiry", inquiry, [0, 0]);

	// only show error message if there are errors
	if (error_message != "") {
		passed = false;
		alert(error_message);
	}

	return passed;
}

function validate(field, data, length, required = true) {
	var error_message = "";

	if (required && data == "") { // blank field
		error_message += "You must enter your " + field + ".\n";
	} else {
		if (data == "" && !required) // if the data is empty and not required, there is no point in checking length
			return error_message;
		if (length[0] == 0 && length[1] == 0) // this means no length validation is required
			return error_message;

		if (data.length < length[0] || data.length > length[1]) { // make sure the data entered is within the length range
			length_message = "Your " + field + " must be ";

			if (length[0] == length[1]) // if the length is the same, that means it must be exactly that length
				length_message += "exactly " + length[0] + " characters long.\n";
			else
				length_message += "between " + length[0] + " and " + length[1] + " characters long.\n";

			error_message += length_message;
		}
	}

	return error_message;
}