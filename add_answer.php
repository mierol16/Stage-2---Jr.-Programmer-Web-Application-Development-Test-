<?php 
	include("db_connect.php");
    session_start();
    $sessionUser = $_SESSION["userID"]; // will be set in login function
    $roleUser = $_SESSION["userFName"]; // will be set in login function

    // check session
    if (empty($sessionUser)) {
        header("Location: login.php?page=loginfirst");  // redirect to logout page first if session is empty
    }

// set the value for the variables
$dd_1 = $dd_2 = '';
$ans_1 = $ans_2 = $ans_3 = $ans_4 = '';
$answerVal = '';

if (isset($_GET['q_id'])) {
	$q_type = $_GET['type'];
	$ans_qId = $_GET['q_id'];
	$result = mysqli_query($db, "SELECT * FROM answers WHERE ans_q_id = {$ans_qId}") or die (mysqli_error($db));
    $row = mysqli_fetch_assoc($result);
    $answerVal = $row['answer'];

    // check the value for the variable if not empty
    if (!empty($answerVal)) {
    	if ($q_type == 1) {
			$answer = explode(",",$answerVal,2); // convert string to array
			$dd_1 = $answer['0'];
			$dd_2 = $answer['1'];
		}elseif ($q_type == 2) {
			$answer = explode(",",$answerVal,4); // convert string to array
			$ans_1 = $answer['0'];
			$ans_2 = $answer['1'];
			$ans_3 = $answer['2'];
			$ans_4 = $answer['3'];
		}
    }
	    
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Answers</title>

	<!-- Custom CSS -->
    <link href="assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">

</head>
<body>
	<!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">Questionaire</a> /
                                        <a href="#">Answer Form</a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    
                </div>
            </div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form action="controller.php" method="POST">
							<div class="form-body">
								<div class="row">
									<?php if($q_type == 2){ ?>
										<div class="col-md-4">
											<div class="form-group">
												<label>Multiple Choice</label><br>
												<label>Option 1 :</label>
												<input type="text" name="ans_1" class="form-control" value="<?= $ans_1 ?>" ><br>
												<label>Option 2 :</label>
												<input type="text" name="ans_2" class="form-control" value="<?= $ans_2 ?>"><br>
												<label>Option 3 :</label>
												<input type="text" name="ans_3" class="form-control" value="<?= $ans_3 ?>"><br>
												<label>Option 4 :</label>
												<input type="text" name="ans_4" class="form-control" value="<?= $ans_4 ?>">
											</div>
										</div>
									<?php }elseif($q_type == 1) { ?>
									<div class="col-md-4">
										<div class="form-group">
											<label>Dropdown Values</label><br>
											<label>Positive Label :</label> 
											<input type="text" name="dd_1" class="form-control" value="<?= $dd_1 ?>"><br>
											<label>Negative Label :</label> 
											<input type="text" name="dd_2" class="form-control" value="<?= $dd_2 ?>">
										</div>
									</div>
									<?php } ?>
								</div>
								<div class="form-actions">
									<hr>
									<center>
										<?php
										// check the value for the variable if empty
										if(empty($answerVal)) {
											$submitName = 'ins_ans';
										}else {
											$submitName = 'edit_ans';
										}
										?>
										<input type="hidden" name="ans_qId" value="<?= $ans_qId; ?>">
										<input type="hidden" name="q_type" value="<?= $q_type; ?>">
										<input type="submit" name="<?= $submitName ?>" class="btn btn-info" value="Submit">
									</center>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<p>
		<a href="index.php" class="btn btn-link float-left">Back to Home</a>
	</p>

</body>
</html>