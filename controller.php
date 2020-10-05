<?php 
	include 'db_connect.php';
	$errors = array(); // records errors problem

	// Start : login 
if (isset($_POST['login_user'])) {

  $username = mysqli_real_escape_string($db, $_POST['username']);
  $enteredPassword = mysqli_real_escape_string($db, $_POST['pass']);

  $user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);

  if (mysqli_num_rows($result) > 0 ) {
  	 $row = mysqli_fetch_assoc($result);
  	 $id =$row['id'];
  	 $dbPassoword =$row['password'];
    
	  if (password_verify($enteredPassword, $dbPassoword)) {

	  	session_start();
		$_SESSION['userID'] = $id;
		$_SESSION['userFName'] = $username;
		$_SESSION['isLogin'] = TRUE;
		header('location: index.php');

		}else{
			header('location: login.php?userlogin=fail');
		}

	}else{

  	// check user table for login
  	$user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);

  	$row = mysqli_fetch_assoc($result);
	$userid =$row['id'];
	$username_ =$row['username'];
	$dbPassoword_ =$row['password'];
  	 
  	if (password_verify($enteredPassword, $dbPassoword_)) {
  		session_start();
	  	$_SESSION['ID'] = $userid;
	  	$_SESSION['userName'] = $username_;
	  	$_SESSION['isLogin'] = TRUE;
	  	header('location: index.php');
	}else{
	  	header('location: login.php?userlogin=fail');
	}

  }
	 
}
// End : login 

//Start : Insert Question
if(isset($_POST['ins_quest'])) {
	$subject = mysqli_real_escape_string($db, $_POST['subject']);
	$question = mysqli_real_escape_string($db, $_POST['quest']);
	$type = mysqli_real_escape_string($db, $_POST['type']);

	date_default_timezone_set('Asia/Kuala_Lumpur'); // set default timezone to  Malaysia
  	$datecreate = date('Y-m-d H:i:a');

	$query = "INSERT INTO question (subject, quest, type, created_at) VALUES ('$subject', '$question', '$type', '$datecreate') ";
	$result = mysqli_query($db, $query); // store the variables for the question table in database

	if($result) {
		$last_id = mysqli_insert_id($db); // get the last id store in database
		header("location: add_answer.php?type=$type&q_id=$last_id");
	}
	else {
		header('location: index.php?submit=fail');
	}
}
//End : Insert Question


//Start : Insert Answer
if(isset($_POST['ins_ans'])) {

	// check for answers type (Dropdown/Multiple Choice)
	if($_POST['q_type'] == 1) { 
		$dd_1 = mysqli_real_escape_string($db, $_POST['dd_1']);
		$dd_2 = mysqli_real_escape_string($db, $_POST['dd_2']);
		$ans_q_id = mysqli_real_escape_string($db, $_POST['ans_qId']);
		$q_type = mysqli_real_escape_string($db, $_POST['q_type']);

		$arr = array($dd_1,$dd_2);
		$ans = implode(",", $arr); // convert array to string

		date_default_timezone_set('Asia/Kuala_Lumpur'); // set default timezone to  Malaysia
	  	$datecreate = date('Y-m-d H:i:a');

		$query = "INSERT INTO answers (ans_q_id, answer) VALUES ('$ans_q_id', '$ans') ";
		$result = mysqli_query($db, $query); // store the variables for the answers table in database

		if($result) {
			header('location: index.php?submit=success');
		}
		else {
			header('location: index.php?submit=fail');
		}

	}

	// check for answers type (Dropdown/Multiple Choice)
	if($_POST['q_type'] == 2) {
		$ans_1 = mysqli_real_escape_string($db, $_POST['ans_1']);
		$ans_2 = mysqli_real_escape_string($db, $_POST['ans_2']);
		$ans_3 = mysqli_real_escape_string($db, $_POST['ans_3']);
		$ans_4 = mysqli_real_escape_string($db, $_POST['ans_4']);
		$ans_q_id = mysqli_real_escape_string($db, $_POST['ans_qId']);
		$q_type = mysqli_real_escape_string($db, $_POST['q_type']);

		$arr = array($ans_1,$ans_2,$ans_3,$ans_4);
		$ans = implode(",", $arr); // convert array to string

		date_default_timezone_set('Asia/Kuala_Lumpur'); // set default timezone to  Malaysia
	  	$datecreate = date('Y-m-d H:i:a');

		$query = "INSERT INTO answers (ans_q_id, answer) VALUES ('$ans_q_id', '$ans') ";
		$result = mysqli_query($db, $query); // store the variables for the answers table in database

		if($result) {
			header('location: index.php?submit=success');
		}
		else {
			header('location: index.php?submit=fail');
		}

	}
}
//End : Insert Answer

//Start : Edit Answer
if(isset($_POST['edit_ans'])) {

	// check for answers type (Dropdown/Multiple Choice)
	if($_POST['q_type'] == 1) {
		$dd_1 = mysqli_real_escape_string($db, $_POST['dd_1']);
		$dd_2 = mysqli_real_escape_string($db, $_POST['dd_2']);
		$ans_q_id = mysqli_real_escape_string($db, $_POST['ans_qId']);
		$q_type = mysqli_real_escape_string($db, $_POST['q_type']);

		$arr = array($dd_1,$dd_2);
		$ans = implode(",", $arr); // convert array to string

		date_default_timezone_set('Asia/Kuala_Lumpur'); // set default timezone to  Malaysia
	  	$datecreate = date('Y-m-d H:i:a');

		$query = "UPDATE answers SET answer = '$ans' WHERE ans_q_id = '$ans_q_id'";
		$result = mysqli_query($db, $query); // update existing variables in database

		if($result) {
			header('location: index.php?submit=success');
		}
		else {
			header('location: index.php?submit=fail');
		}

	}

	// check for answers type (Dropdown/Multiple Choice)
	if($_POST['q_type'] == 2) {
		$ans_1 = mysqli_real_escape_string($db, $_POST['ans_1']);
		$ans_2 = mysqli_real_escape_string($db, $_POST['ans_2']);
		$ans_3 = mysqli_real_escape_string($db, $_POST['ans_3']);
		$ans_4 = mysqli_real_escape_string($db, $_POST['ans_4']);
		$ans_q_id = mysqli_real_escape_string($db, $_POST['ans_qId']);
		$q_type = mysqli_real_escape_string($db, $_POST['q_type']);

		$arr = array($ans_1,$ans_2,$ans_3,$ans_4);
		$ans = implode(",", $arr); // convert array to string

		date_default_timezone_set('Asia/Kuala_Lumpur'); // set default timezone to  Malaysia
	  	$datecreate = date('Y-m-d H:i:a');

		$query = "UPDATE answers SET answer = '$ans' WHERE ans_q_id = '$ans_q_id'";
		$result = mysqli_query($db, $query); // update existing variables in database

		if($result) {
			header('location: index.php?submit=success');
		}
		else {
			header('location: index.php?submit=fail');
		}

	}
}
//End : Edit Answer

?>