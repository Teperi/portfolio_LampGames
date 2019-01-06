<?php
if (isset($_POST["rememberme"])) {
    $duration = 7 * 24 * 60 * 60;
    ini_set('session.gc_maxlifetime', $duration);
    session_set_cookie_params($duration);
}
session_start();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>로그인 - Lamp Games</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body class="yellow lighten-2">
<?php
// DB 접속해주는 PHP 파일 $conn 으로 접속되어있음.
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connectDB.php';

// console 에서 확인하기 위한 debug 함수 Console_log 사용
// require_once 'console_log.php';
// id password 변수 만들기
$id = $password = "";
// 웹페이지 방식에서 POST 전송이 되었을 때만 작업 시행
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 입력한 ID 및 PASSWORD 가져오기
    $id = $_POST["id"];
    $password = $_POST["password"];
    // Console_log($id);
    // Console_log($password);

    // 쿼리 만들기
    $sql = "SELECT id, password, nickName FROM user_info WHERE id='" . $id . "'";

    // DB 에 쿼리 날리기
    $result = mysqli_query($conn, $sql);

    // 쿼리 결과를 PHP 에서 사용할 수 있도록 변경
    $row = mysqli_fetch_assoc($result);
    // 아이디 및 패스워드 확인해서 맞는 결과 보내주기.
    // NEXT: password_verify($password , $row["password"]) 로 변경(회원가입 hash 적용 후)
    if ($row == null) {
        echo "<script>
                alert('아이디가 존재하지 않습니다.');
                history.back();
            </script>";
    } else {
        if (!password_verify($password, $row['password'])) {
            echo "<script>
                alert('비밀번호가 틀렸습니다.');
                history.back();
            </script>";
        } else {
            $_SESSION['user_id'] = $id;
            $_SESSION['nickName'] = $row['nickName'];
            $nickName = $row['nickName'];
            echo "<script>
                alert('$nickName 님 환영합니다.');
                document.location.href='/index.html'
            </script>";
        }
    }
} else {

}
?>
</body>
</html>

