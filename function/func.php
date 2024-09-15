<?php
session_start();
if(!empty($_SESSION['user'])) {
	header('location: dashboard.php');
}
$err = array();
function vd($data) {
	$data = trim($data);
	$data = htmlspecialchars($data);
	$data = stripslashes($data);
	return $data;
}
?>