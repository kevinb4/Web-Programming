<?php

	//include database access class
	include("db_mysql.php");

	//declare the database instance
	$db = new DB_Sql;

	$function = $_POST['command'];

	//if we need to get the list of available projects, return the appropriate XML data
	if ($function == "get_projects")
	{
		//array containing the list of projects
		$project_list = [];

		//the query to get the list of available projects
		$query = "SELECT * FROM Projects";

		//do the query
		$db->query($query);

		while ($db->next_record())
		{
			//store the database columns as variables
			$project_num = $db->f("project_num");
			$project_name = $db->f("project_name");
			
			//push the data onto the array that we intend to return
			array_push($project_list, ["project_number" => $project_num, "project_full_name" => $project_name]);
				
		}//end while, all available projects are pushed onto the project_list array	

		//return the data in JSON format
		echo json_encode(["status" => "Success", "list_of_projects" => $project_list]);
		
	}//end if we need the list of current projects in the database

	//if we need to get the list of tasks by project, return the appropriate XML data
	else if ($function == "get_tasks")
	{
		// don't allow getting tasks if the user isn't logged in
		// if (!isset($_POST['username']))
		// 	return;

		//get the variables we need to run the query
		$project_num = cleanInput($_POST['project_number']);

		//array containing the list of projects
		$task_list = [];

		//the query to get the list of tasks for the project
		$query = "SELECT * FROM Tasks WHERE Project_Num=$project_num";

		//do the query
		$db->query($query);

		while ($db->next_record())
		{
			//store the database columns as variables
			$task_num = $db->f("task_num");
			$description = $db->f("Description");
			$status = $db->f("Status");
			
			//push the data onto the array that we intend to return
			array_push($task_list, ["task_number" => $task_num, "task_description" => $description, "task_status" => $status]);
					
		}
		//end while, all available tasks for the specified project are pushed onto the task_list array	

		//return the data in JSON format
		echo json_encode(array("status" => "Success", "list_of_tasks" => $task_list));

	}//end if we need the list of tasks
	else if ($function == "login")
	{
		$login_username = cleanInput($_POST['username']);
		$login_password = $_POST['password'];

		// find the username
		$db->query("SELECT username, password FROM accounts WHERE username='$login_username'");

		// this should not be a loop because there should only be one record, and could cause problems
		while ($db->next_record())
		{
			$un = $db->f("username");
			$pw = $db->f("password");

			// passwords aren't being hashed, but that's not a requirement
			if ($login_password == $pw)
			{
				$username = $un;
				echo json_encode(["status" => "success", "username" => $login_username]);
			}
			else
			{
				echo json_encode(["status" => "fail", "message" => "Incorrect credentials"]);
			}
		}

		if ($db->nf() == 0)
		{
			echo json_encode(["status" => "fail", "message" => "Incorrect credentials"]);
		}
	}

	function cleanInput($input)
	{
		// to prevent sql injection
		$input = trim($input);
		$input = str_replace("'", "\'", $input); // replace single quotes with escaped single quotes
		$input = str_replace('"', '\"', $input); // replace double quotes with escaped double quotes
		return $input;
	}
?>