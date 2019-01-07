<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/php/connectDB.php';

$idx = json_decode($_POST['idx']);

if (gettype($idx) == 'array') {
    // 일괄삭제로 값이 넘어온 경우
    $sql = 'DELETE FROM reviewList';
    foreach ($idx as $key => $value) {
        if ($key == 0) {
            $sql = $sql . ' WHERE listidx = \'' . $value . '\'';
        } else {
            $sql = $sql . ' OR listidx = \'' . $value . '\'';
        }
    }
    return mysqli_query($conn, $sql);

} else {
    // 글 1개 삭제로 값이 넘어온 경우
    $sql = 'DELETE FROM reviewList WHERE listidx = \'' . $idx . '\'';

    return mysqli_query($conn, $sql);
}
