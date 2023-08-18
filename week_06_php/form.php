<?php
	include("functions.php");

	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$address = trim($_POST['address']);
	$phone = trim($_POST['phone']);
	$inquiry = trim($_POST['inquiry']);
	$message = "";

	if (isset($_POST['submit'])) // check if the button was pressed so we don't get "form was submitted" when first loading the page
	{
		// run through required validation functions
		$message .= validateName("first name", $first_name, [3, 10]);
		$message .= validateName("last name", $last_name, [2, 15]);
		$message .= validateAddress($address);
		$message .= validatePhone($phone);
		$message .= validateInquiry($inquiry);

		// set page message using bootstrap alerts at the top depending on result of validation
		if ($message != "")
			$message = "<div class=\"alert alert-danger\" role=\"alert\">" . $message . "</div>";
		else
			$message = "<div class=\"alert alert-success\" role=\"alert\">The form has been submitted successfully!</div>";
	}
?>

<html>
	<head>
		<title>Contact Form</title>
		<meta name="keywords" content="webpage, IT 413, assignment, contact form">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
	</head>

	<body>
		<?php echo $message; ?>
		<h3>Contact</h3>
		<!-- define the form for data submission -->
		<form action="form.php" method="post">
			<p>Use the form below to get in contact with us about any kind of inquiry. Please allow 24-48 hours for us to review your message and get back to you with relavent information.</p>
			
			<div class="mb-3">
				<label for="first_name" class="form-label">First Name</label>
				<input type="text" class="form-control" id="first_name" name="first_name" placeholder="John" value="<?php echo $first_name; ?>">
			</div>
			<div class="mb-3">
				<label for="last_name" class="form-label">Last Name</label>
				<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Smith" value="<?php echo $last_name; ?>">
			</div>
			<div class="mb-3">
				<label for="address" class="form-label">Address</label>
				<input type="text" class="form-control" id="address" name="address" placeholder="1234 Apple Ave." value="<?php echo $address; ?>">
			</div>
			<div class="mb-3">
				<label for="phone" class="form-label">Phone Number</label>
				<input type="text" class="form-control" id="phone" name="phone" placeholder="555-321-5487" value="<?php echo $phone; ?>">
			</div>
			<div class="mb-3">
				<label for="inquiry" class="form-label">Inquiry</label>
				<textarea class="form-control" id="inquiry" name="inquiry" rows="3" placeholder="What can we help you with?"><?php echo $inquiry; ?></textarea>
			</div>

			<input type="submit" name="submit" value="Submit" class="btn btn-primary mb-3">
		</form>
	</body>
</html>