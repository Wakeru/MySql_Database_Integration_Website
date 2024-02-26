<?PHP
	require_once('./configure.php');

	$ID_schedule = $_POST['ID_schedule'];
	$ID_student = $_POST['ID_student'];
	$ID_course = $_POST['ID_course'];
	$sched_yr = $_POST['sched_yr'];
	$sched_sem = $_POST['sched_sem'];
	$grade_letter = $_POST['grade_letter'];

    if($ID_schedule == ""){
		$ID_schedule ="none given";}
    if($ID_student == ""){
		$ID_student = "none given";}
    if($ID_course == ""){
		$ID_course = "none given";}


    if($sched_yr == ""){
		$sched_yr = date("yyyy");}
    if($sched_sem == ""){
		$sched_sem = date("FA");}
    if($grade_letter == ""){
		$grade_letter = date("W");}


	$option = $_POST["option"];
    if ($option == "Search Schedule"){
	$select_statement_valid = 1;
	/*search for the student*/
	echo "Searching for <b>Schedule ID:</b> $ID_schedule <b>Student ID:</b> $ID_student <b>Course ID:</b> $ID_course <br />";
	if($ID_schedule == NULL AND $ID_student == NULL AND $ID_course == NULL){
		echo "Must include course information to search<br />";
		echo "<form action='./schedules.html' method='get'><input type='submit' value='Go Back to Manage Schedules'/></form>";
		echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		$select_statement_valid = 0;
	}
	elseif($ID_schedule != NULL){
		$SELECT = "SELECT * FROM t_schedules WHERE t_schedules.ID_schedule=$ID_schedule";
	}
	elseif($ID_student != NULL){
		$SELECT = "SELECT * FROM t_schedules WHERE t_schedules.ID_student =$ID_student";
	}
	elseif($ID_course != NULL){
		$SELECT = "SELECT * FROM t_schedules WHERE t_schedules.ID_course =$ID_course";
	}



	else{
		echo "An error constructing SELECT statement.";
		$select_statement_valid = 0;
	}
	if($select_statement_valid == 1){
		$resultSet = $conn->query($SELECT);
		if($resultSet->num_rows > 0){
			echo "Search Results Found Records Listed. <br>Click student to pre-fill information form.<br />";
			while($rows = $resultSet->fetch_assoc()){
				$ID_schedule = $rows['ID_schedule'];
				/*ID_student = $rows['ID_student'];*/
				/*$ID_course = $rows['ID_course'];*/
				$sched_yr = $rows['sched_yr'];
				$sched_sem = $rows['sched_sem'];
				$grade_letter = $rows['grade_letter'];


				$post_string = $ID_schedule; 
				$post_string = $post_string . "&" . "sched_yr =" . $sched_yr;
				$post_string = $post_string . "&" . "sched_sem =" . $sched_sem; 
				$post_string = $post_string . "&" . "grade_letter =" . $grade_letter; 

				/*value='$ID_student +'*/
				echo "<br/br/><form action='./schedules.html' method='GET'><button type='submit' name='ID_schedule' id='ID_schedule' value='$post_string'>Schedule ID: $ID_schedule, Student ID: $ID_student, Course ID: $ID_course </button></form>";	
			}
			echo "<br/><br/><form action='./schedules.html' method='get'><input type='submit' value='Go Back to Manage Schedules'/></form>";
 		}
		else{
			echo "Error in searching for student record(s).";
			echo "<form action='./schedules.html' method='get'><input type='submit' value='Go Back to Manage Schedules'/></form>";
		}
	}
		
     mysqli_close($conn);
    }
    else if ($option == "Add Schedule"){
        /* For inserting a schedule record */
	if($fname != "" && $lname != ""){
		$INSERT = "INSERT INTO t_students (fname, lname, phone, email, status, start_dte, end_dte) VALUES ('$fname', '$lname', '$phone', '$email', '$status', '$start_dte', '$end_dte')";
		$stmt = $conn->prepare($INSERT);
                	//$stmt->bind_param('ssssiss', $fname, $lname, $phone, $email, "0", "2019-11-02", "2019-11-04");
                	$stmt->execute();
		$rnum = $stmt->affected_rows;
		printf("Number of rows effected: %d and %d.\n", $stmt->affected_rows, $rnum);
		if($rnum == 1){
			echo "New record inserted successfully";
			echo "<form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Students'/></form>";
                		echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		else{
			echo "Failure to Insert record.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}

		mysqli_close($conn);
	}
	else {
		echo "All fields (except student ID) are required";
		echo "<form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Students'/></form>";
		die();
	}
    }
    else if ($option == "Edit Student"){
               /*Update Editing a student*/
		if($ID_student != ""){
//$UPDATE = "UPDATE t_students SET fname='$fname', lname='$lname' WHERE ID_student='$ID_student'";
			$UPDATE = "UPDATE t_students SET fname='$fname', lname='$lname', phone='$phone', email='$email', status='$status', start_dte='$start_dte', end_dte='$end_dte' WHERE ID_student='$ID_student'";

		//$UPDATE = "UPDATE t_students SET fname='$fname', lname='$lname', ";
		//$UPDATE = $UPDATE + "phone='$phone', email='$email', status='$status', ";
		//$UPDATE = $UPDATE + "start_dte='$start_dte', end_dte='$end_dte' WHERE ID_student='$ID_student'";

			$stmt = $conn->prepare($UPDATE);
			$stmt->execute();
			$rnum = $stmt->affected_rows;
			printf("Number of rows effected: %d and %d.\n", $stmt->affected_rows, $rnum);
			if($rnum == 1){
				echo "Updated student successfully.";
				echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
			}
			else{
				echo "Failure to Update record.";
				echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
			}

			mysqli_close($conn);
		}
		else {
			echo "Error in updating student must include student ID to edit record.";
			echo "<form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Students'/></form>";
			die();
		}
    }
    else if ($option == "Delete Student"){
	/*Deleting a student*/
		if($ID_student != ""){

			$DELETE = "DELETE FROM t_students WHERE ID_student='$ID_student'";
			$stmt = $conn->prepare($DELETE);
			$stmt->execute();
			$rnum = $stmt->affected_rows;
			printf("Number of rows effected: %d and %d.\n", $stmt->affected_rows, $rnum);
			if($rnum == 1){
				echo "Deleted student successfully.";
				echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
			}
			else{
				echo "Failure to Delete record.";
				echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
			}
			mysqli_close($conn);
		}
		else {
			echo "Error in deleting student must include student ID to delete record.";
			echo "<form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Students'/></form>";
			die();
		}
    }
    else{
		echo "Error: Option not found.";
		echo "<form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Students'/></form>";
    }
?>