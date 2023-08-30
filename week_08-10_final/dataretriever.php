<?php
	// use mysqli directly instead of the sql wrapper for better functionality
	$db = new mysqli("localhost", "root", "1234", "final_project");

	if ($db->connect_errno) {
		echo json_encode(["status" => "error", "message" => "Failed to connect to the database"]);
		exit();
	}

	$function = $_POST['command'];

	// if we need to get the list of available projects, return the appropriate XML data
	if ($function == "get_projects")
	{
		// array containing the list of projects
		$project_list = [];

		// run the query
		$result = $db->query("SELECT * FROM Projects");

		while ($row = mysqli_fetch_assoc($result))
		{
			// store the database columns as variables
			$project_num = $row["project_num"];
			$project_name = $row["project_name"];
			
			// push the data onto the array that we intend to return
			array_push($project_list, ["project_number" => $project_num, "project_full_name" => $project_name]);
				
		}
		// end while, all available projects are pushed onto the project_list array	

		// return the data in JSON format
		echo json_encode(["status" => "Success", "list_of_projects" => $project_list]);
		
	}
	// end if we need the list of current projects in the database

	// if we need to get the list of tasks by project, return the appropriate XML data
	else if ($function == "get_tasks")
	{
		// get the variables we need to run the query
		$project_num = $_POST['project_number'];

		// array containing the list of projects
		$task_list = [];

		// prepare the sql query and bind the parameter to prevent sql injection, then execute and get the results
		$stmt = $db->prepare("SELECT * FROM Tasks WHERE Project_Num=?");
		$stmt->bind_param("s", $project_num);
		$stmt->execute();
		$result = $stmt->get_result();

		foreach ($result as $row)
		{
			// store the database columns as variables
			$task_num = $row["task_num"];
			$description = $row["Description"];
			$status = $row["Status"];
			
			// push the data onto the array that we intend to return
			array_push($task_list, ["task_number" => $task_num, "task_description" => $description, "task_status" => $status]);
					
		}
		// end while, all available tasks for the specified project are pushed onto the task_list array	

		// return the data in JSON format
		echo json_encode(["status" => "Success", "list_of_tasks" => $task_list]);

	}
	// end if we need the list of tasks

	// start of login handler
	else if ($function == "login")
	{
		$login_username = $_POST['username'];
		$login_password = $_POST['password'];

		// prepare the sql query and bind the parameter to prevent sql injection, then execute and get the results
		$stmt = $db->prepare("SELECT username, password FROM accounts WHERE username=?");
		$stmt->bind_param("s", $login_username);
		$stmt->execute();
		$result = $stmt->get_result();

		// if nothing was returned, the user doesn't exist but display incorrect credentials to prevent username enumeration
		if ($result->num_rows == 0)
		{
			echo json_encode(["status" => "fail", "message" => "Incorrect credentials"]);
		}
		else
		{
			$row = $result->fetch_assoc();
			$un = $row["username"];
			$pw = $row["password"];

			// passwords aren't being hashed as it's not a requirement
			if ($login_password == $pw)
				echo json_encode(["status" => "success", "username" => $login_username]);
			else
				echo json_encode(["status" => "fail", "message" => "Incorrect credentials"]);
		}
	}
	// end of login handler
?>