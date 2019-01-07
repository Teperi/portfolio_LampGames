<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/php/connectDB.php';

$idx = $_POST['idx'];

$sql = 'DELETE FROM reviewList WHERE listidx = \'' . $idx . '\'';

return mysqli_query($conn, $sql);
