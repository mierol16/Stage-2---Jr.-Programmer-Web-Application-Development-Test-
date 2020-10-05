<?php

session_start();

session_unset();

session_destroy();

if (isset($_GET['page']) == "notfound" ) {
	header("location:error/404.php");
}else{
	header("location:login.php");
}

exit();

?>