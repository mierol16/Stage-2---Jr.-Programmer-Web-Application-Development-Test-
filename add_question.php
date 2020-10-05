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
    $qusetionVal = '';
    $typeVal = '';
    $subjectVal = '';
    $qId = '';

    if(isset($_GET['q_id'])){
    	$qId = $_GET['q_id'];
    	$result = mysqli_query($db, "SELECT * FROM question WHERE q_id = {$qId}") or die (mysqli_error($db));
    	$row = mysqli_fetch_assoc($result);
    	$subjectVal = $row['subject'];
    	$typeVal = $row['type'];
    	$qusetionVal = $row['quest'];
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Questionaire</title>

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
                                        <a href="#">Question Form</a>
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
									<div class="col-md-4">
										<div class="form-group">
											<label>Subject</label>
											<input type="text" name="subject" class="form-control" value="<?= $subjectVal; ?>">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Type</label>
											<select name="type" class="form-control">
												<option value="">Please Select</option>
												<?php 
													$query = mysqli_query($db, "SELECT * FROM q_type") or die (mysqli_error($db));

													foreach ($query as $row) {
														$selected = '';
														if($row['type_id'] == $typeVal){
															$selected = 'selected';
														}
														echo "<option value='{$row['type_id']}' {$selected}>{$row['type_desc']}</option>";
													}
												?>
												<!-- <option value="Multiple Choice">Multiple Choice</option> -->
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Question</label>
											<textarea name="quest" class="form-control" value="<?= $qusetionVal; ?>"></textarea>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<hr>
									<center>
										<?php 
										if (isset($_GET['id'])) {
											$submitName ='edit_quest';
										}else{
											$submitName = 'ins_quest';
										}
										?>
										<input type="hidden" name="q_id" value="<?= $qId; ?>">
										<input type="submit" name="<?= $submitName; ?>" class="btn btn-info" value="Submit">
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