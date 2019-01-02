<?php
require_once '/php/connectDB.php';

if( isset($_POST['id']) ){
    $uid = $_POST["id"];
    $sql = "SELECT * FROM user_info WHERE id = '$uid'";
    // DB 에 쿼리 날리기
    $result = mysqli_query($conn,$sql);
        
    // 쿼리 결과를 PHP 에서 사용할 수 있도록 변경
    $row = mysqli_fetch_assoc($result);

    echo $row['id'];

} else if (isset($_POST['nick'])){
    $nick = $_POST["nick"];
    $sql = "SELECT * FROM user_info WHERE nickName = '$nick'";
    // DB 에 쿼리 날리기
    $result = mysqli_query($conn,$sql);
        
    // 쿼리 결과를 PHP 에서 사용할 수 있도록 변경
    $row = mysqli_fetch_assoc($result);

    echo $row['id'];
} else if (isset($_POST['email'])) {
    $email = $_POST["email"];
    $sql = "SELECT * FROM user_info WHERE email = '$email'";
    // DB 에 쿼리 날리기
    $result = mysqli_query($conn,$sql);
        
    // 쿼리 결과를 PHP 에서 사용할 수 있도록 변경
    $row = mysqli_fetch_assoc($result);

    echo $row['id'];
}


?>