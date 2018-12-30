<?php
require_once 'connectDB.php';

$id = $email = $hash = $nickname = $password = "";
// 웹페이지 방식에서 POST 전송이 되었을 때만 작업 시행
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id=$_POST['id'];
    $nickname = $_POST['nickName'];
    $email=$_POST['email'];
    $password=$_POST['passwordFirst'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    // 쿼리 만들기
    $sql = "INSERT INTO user_info (id, nickName, email, password)
        VALUES ('$id', '$nickname', '$email', '$hash');";
    // DB 에 쿼리 날리기
    $result = mysqli_query($conn,$sql);
    
    if($result === true) {
        echo "<script>
            alert('회원가입이 완료되었습니다.');
            document.location.href='../index.html'
            </script>";
    } else {
        echo "<script>
            alert('회원가입에 실패하였습니다.\\n다시 시도해 주세요.');
            history.back();
            </script>";
    }
}


?>