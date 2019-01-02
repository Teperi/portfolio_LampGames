<?php
require_once '/php/connectDB.php';


$hash = password_hash('33',PASSWORD_DEFAULT);
$sql = "INSERT INTO user_info (id, nickName, email, password)
       VALUES ('servertest', 'test', 'tt@aa.cc', '$hash' );";

echo $sql;

mysqli_query($conn,$sql);
  
  // DB 에 쿼리 날리기
    // $result = mysqli_query($conn,$sql);
    
    // if($result === true) {
    //     // echo "<script>
    //     //     alert('회원가입이 완료되었습니다.');
    //     //     document.location.href='../index.html'
    //     //     </script>";
    // } else {
    //     // echo "<script>
    //     //     alert('회원가입에 실패하였습니다.\\n다시 시도해 주세요.');
    //     //     history.back();
    //     //     </script>";
    // }
    ?>