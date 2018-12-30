<!-- PHP 와 MYSQL 연결해주는 PHP
	require_once 'connectDB.php';
	을 다른 파일어 넣은 후
	$conn 으로 사용 가능함

	서버가 죽었을 경우 error 띄움
-->

<?php
$host='localhost';
$user='root';
$pw='hievening5';
$dbName='lampgamesdb';
$conn = new mysqli($host, $user, $pw, $dbName);
if ($conn->connect_error) {

	die("Connection failed: " . $conn->connect_error);

	}
?>
