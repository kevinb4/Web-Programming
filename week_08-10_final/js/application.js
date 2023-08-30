$(document).ready(function() {
	// add/edit task buttons section start
	$('#add_task_button').click(function() {
		// define the modal necessities
		var title = "Add Task",
			body = `<form>
				<p class="fw-bold">Adding a task for project "${$('#project_selector option:selected').text()}"</p>
				<div class="mb-3">
					<label for="task_description" class="form-label">Task Description</label>
					<input type="text" class="form-control" id="task_description" name="task_description" placeholder="Enter task description">
				</div>
				<div class="mb-3">
					<label for="task_status" class="form-label">Task Status</label>
					<select class="form-select" id="task_status" name="task_status">
						<option value="1">Unassigned</option>
						<option value="2">In Process</option>
						<option value="3">Resolved</option>
					</select>
				</div>
			</form>`,
			footer = '<button type="button" class="btn btn-primary" id="add_task_submit">Submit</button><button 		type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';

		// if no project is selected, show an error message instead
		if ($('#project_selector').val() == '0') {
			title = "Notice";
			body = "Please select a project before adding a task.";
			footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
		}

		// define the modal and add in the title, body, and footer
		var myModal = new bootstrap.Modal(document.getElementById('modal'));
		$('#modalTitle').html(title);
		$('#modalBody').html(body);
		$('#modalFooter').html(footer);
		myModal.show();
	});

	$('#edit_task_button').click(function() {
		$.post("dataretriever.php", {command: "get_tasks", project_number: $('#project_selector').val()}, function(data) {
			// start building modal
			var title = "Edit Task",
				body = `<form>
				<p class="fw-bold">Editing a task for project "${$('#project_selector option:selected').text()}"</p>
				<div class="mb-3">
					<label for="task_description" class="form-label">Task Number</label>
					<select class="form-select" id="task_status" name="task_status">`,
				count = 0;

			// loop through the tasks and add them to the modal to select them
			while (count < data.list_of_tasks.length) {
				var num = data.list_of_tasks[count].task_number;

				body += `<option value="${num}">${num}</option>`;
				count++;
			}

			// finish building modal
			body += `</select>
					</div>
					<div class="mb-3">
						<label for="task_description" class="form-label">Task Description</label>
						<input type="text" class="form-control" id="task_description" name="task_description" placeholder="Enter task description">
					</div>
					<div class="mb-3">
						<label for="task_status" class="form-label">Task Status</label>
						<select class="form-select" id="task_status" name="task_status">
							<option value="1">Unassigned</option>
							<option value="2">In Process</option>
							<option value="3">Resolved</option>
						</select>
					</div>
				</form>`;
			footer = '<button type="button" class="btn btn-primary" id="add_task_submit">Submit</button><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';

			// if no project is selected, show an error message instead
			if ($('#project_selector').val() == '0') {
				title = "Notice";
				body = "Please select a project before editing a task.";
				footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
			}

			// define the modal and add in the title, body, and footer
			var myModal = new bootstrap.Modal(document.getElementById('modal'));
			$('#modalTitle').html(title);
			$('#modalBody').html(body);
			$('#modalFooter').html(footer);
			myModal.show();
		}, "json");
	});
	// add/edit task buttons section end

	// login/logout buttons section start
	$('#login_button').click(function() {
		validateUser();
		return false;
	});

	$('#logout_button').click(function() {
		// fade the project selector out and the login form back in
		$('#select_project_state').fadeOut(500, function() {
			$('#login_state').fadeIn(500);
		});

		// try to logout of facebook in case that was used
		try {
			FB.logout(function(response) {
				statusChangeCallback(response);
			});
		} catch {
			console.log("Facebook logout failed. Perhaps built-in account was used.")
		}
	});
	// login/logout buttons section end

	// project selector section start
	$('#project_selector').on('change', function() {
		$('#projectData').empty();

		// if the user selects the default option, show the default text and return since there's no data to obtain
		if (this.value == '0') {
			$('#title').html('Select a Project');
			$('#description').html('Select a project below to get the tasks and their status.');
			return;
		}
		
		$.post("dataretriever.php", {command: "get_tasks", project_number: this.value}, function(data) {
			var count = 0;

			// change text to show the project name
			$('#title').html($('#project_selector option:selected').text());
			$('#description').html('Below are the tasks and their status for the selected project.');

			// start building the table
			var table = '<thead><tr><th scope="col">Task #</th><th scope="col">Task Description</th><th scope="col">Task Status</th></tr></thead><tbody>';

			// loop through the tasks and add them to the table
			while (count < data.list_of_tasks.length) {
				table += '<tr><td>' + data.list_of_tasks[count].task_number + '</td><td>' + data.list_of_tasks[count].task_description + '</td><td>' + data.list_of_tasks[count].task_status + '</td></tr>';
				
				count++;
			}

			// append built table
			$('#projectData').append(table + '</tbody>');
		}, "json").fail(function() {		
			// define the modal and show it with the error message
			var myModal = new bootstrap.Modal(document.getElementById('modal'));
			$('#modalTitle').html("Error");
			$('#modalBody').html("Failed getting project details");
			myModal.show();
		});
	});
	// project selector section end

	// facebook start section
	$.ajaxSetup({ cache: true });
	$.getScript('https://connect.facebook.net/en_US/sdk.js', function() {
		FB.init({
			appId: '860778135609631',
			version: 'v2.7'
		});
		FB.getLoginStatus(function(response) {
			statusChangeCallback(response);
		});
	});

	$('#login_fb').click(function() {
		FB.login(function(response) {
			statusChangeCallback(response);
		});
	});
	// facebook end section
});
// end document ready section

// begin getProjects section
function getProjects() {
	$.post("dataretriever.php", {command: "get_projects"}, function(data) {
		var count = 0;

		// empty the project selector and add the default option
		$('#project_selector').empty();
		$('#project_selector').append('<option value="0" selected>Select a Project</option>');

		// loop through the projects and add them to the selector
		while (count < data.list_of_projects.length) {
			$('#project_selector').append('<option value="' + data.list_of_projects[count].project_number + '">' + data.list_of_projects[count].project_full_name + '</option>');
			count++;
		}
	}, "json").fail(function() {
		// define the modal and show it with the error message
		var myModal = new bootstrap.Modal(document.getElementById('modal'));
		$('#modalBody').html("Web service call failed");
		myModal.show();
	});
}
// end getProjects section

// begin getProjectDetails section
function statusChangeCallback(response) {
	if (response.status === 'connected') {
		getProjects();
		$('#login_state').fadeOut(500, function() {
			$('#select_project_state').fadeIn(500);
		});
	} else {
		console.log(response);
	}
}
// end getProjectDetails section

// begin validateUser section
function validateUser() {
	var username = $('#login_username').val();
	var password = $('#login_password').val();

	// clear borders in case they were red from a previous error
	$('#login_username').css("border-color", "");
	$('#login_password').css("border-color", "");

	// no username validation specified in requirements, so we're just making sure something was entered
	if (username == '' || password == '') {
		// shake the login form and show an error message
		$('#login_form').effect("shake");

		// set the border color to red for the empty fields
		if (username == '')
			$('#login_username').css("border-color", "red");
		if (password == '')
			$('#login_password').css("border-color", "red");
	} else {
		// send the username and password to the web service
		$.post("dataretriever.php", {command: "login", username: username, password: password}, function(data) {
			if (data.status == 'success') {
				getProjects();
				$('#login_state').fadeOut(500, function() {
					$('#select_project_state').fadeIn(500);
					$('#errors').hide(); // hide the error message in case user logs out
				});
			} else if (data.status == 'fail') {
				$('#errors').slideUp(500, function() {
					$('#errors').html(data.message);
					$('#errors').slideDown();
				});
			}
			
		}, "json").fail(function() {
			// if the web service call fails, show an error message
			$('#errors').slideUp(500, function() {
				$('#errors').html("Login failed, please try again");
				$('#errors').slideDown();
			});
		});
	}
}
// end validateUser section