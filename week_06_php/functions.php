<?php
	function badCharCheck($toCheck, $field)
	{
		if ($field == "first name")
			$badChars = [ "@", "#", "$", "\"", "{", "{", "%" ]; // chars not allowed in the first name
		else if ($field == "last name")
			$badChars = [ "@", "#", "$", "\"", "^", "&", "*", "%" ]; // chars not allowed in the last name
		else
			return false; // field not recognized
		
		$passed = false;
		$checkArray = str_split($toCheck); // split the string into an array of characters

		foreach ($checkArray as $letter)
		{
			if (in_array($letter, $badChars)) // checks each character against those in the array
			{
				$passed = false;
				break; // break out so it doesn't get set to true by a later letter in the string
			}
			else
			{
				$passed = true;
			}
		}

		return $passed;
	}

	function validateAddress($data)
	{
		if ($data != "" && (strlen($data) < 8 || strlen($data) > 25)) // check to see if it was entered, and if it was, validate length
			return "Your address must be between 8 and 25 characters long.<br>";
		else
			return "";
	}

	function validateInquiry($data)
	{
		if (empty($data)) // make sure it was entered
			return "Please enter your inquiry.";
		else
			return "";
	}

	function validateName($field, $data, $length)
	{
		$errorMessage = "";
		
		if (empty($data)) // return the error since we don't need any additional validation if nothing was entered
			return "Please enter your " . $field . ".<br>";
		if (strlen($data) < $length[0] || strlen($data) > $length[1]) // make sure the data entered is within the length range
			$errorMessage .= "Your " . $field . " must be between " . $length[0] . " and " . $length[1] . " characters long.<br>";
		if (!badCharCheck($data, $field)) // use the function to check for bad characters
			$errorMessage .= "Your " . $field . " cannot contain special characters.<br>";

		return $errorMessage;
	}

	function validatePhone($data)
	{
		$errorMessage = "";
		$length = 10; // default length is 10

		if (strpos($data, "-") !== false) // but if the user typed in dashes then make sure it's 12 characters long
			$length = 12;

		if (empty($data)) // make sure it was entered
			$errorMessage = "Please enter your phone number.<br>";
		else if (strlen($data) != $length) // make sure it's the proper length
			$errorMessage = "Your phone number must be " . $length . " characters long.<br>";

		return $errorMessage;
	}
?>