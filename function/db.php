<?php
$host = "localhost";
$dbname = "test2";
$user = "root";
$pass = "";
$port = "3306";
try {
	$conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOExcenption $e) {
	echo 'ERR : ' . $e->getMessage();
}
?>