<?php 
	include("db_connect.php");
    session_start();
    $sessionUser = $_SESSION["userID"]; // will be set in login function
    $roleUser = $_SESSION["userFName"]; // will be set in login function

    // check session
    if (empty($sessionUser)) {
        header("Location: login.php?page=loginfirst");  // redirect to logout page first if session is empty
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>List of Questionaire</title>

	<!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link href="assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="dist/js/app-style-switcher.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!--This page plugins -->
    <script src="assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/pages/datatable/datatable-basic.init.js"></script>
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
                                        <a href="#">List of Questionaire</a>
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
				
				<!-- start : alert -->
                        <?php if (isset($_GET['submit']) == "success") { ?>
                            <div class="alert alert-success" role="alert">
                                <strong>Success !</strong> Successfully submitted.
                            </div>
                        <?php }else if (isset($_GET['submit']) == "fail") { ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Alert !</strong> Unsuccessfully submitted.
                            </div>
                        <?php } ?>
                        <!-- end : alert -->

					<p>
                       	<a href="add_question.php" class="btn btn-info float-right">Add Question</a> <br><br>
                    </p>

					<div class="table-responsive">
						<table id="zero-config" class="table table-strip table-bordered no-wrap">
							<thead class="thead-dark">
								<th>#</th>
								<th>Subject</th>
								<th>Type</th>
								<th>Questions</th>
								<th>Answers</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php 

								$result = mysqli_query($db, "SELECT * FROM question left JOIN answers ON ans_q_id = q_id INNER JOIN q_type ON type_id = type") or die (mysqli_error($db)); 

								$no = 1;

								foreach ($result as $row) {
									$Id = $row['q_id'];
									$type = $row['type_id'];
								

								?>
							<tr>
								<td><?= $no; ?></td>
								<td> <?= $row['subject']; ?></td>
								<td> <?= $row['type_desc']; ?></td>
								<td> <?= $row['quest']; ?></td>
								<td> <?= $row['answer'] ?></td>
								<td>
									<center>
										<button onclick="window.location.href='add_answer.php?type=<?=$type; ?>&q_id=<?=$Id; ?>'" class="btn btn-success" >Edit</button>
									</center>
								</td>
							</tr>
							<?php $no++; } ?>
							</tbody>
						</table>
					</div>
					<p>
						<a href="logout.php" class="btn btn-warning float-left">Logout</a> <br><br>
					</p>
						</div>
					</div>
				</div>
			</div>
			
		</div>

</body>
</html>