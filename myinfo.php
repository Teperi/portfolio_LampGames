<!DOCTYPE html>
<html>
<?php session_start(); ?>
<head>
    <meta charset="utf-8" />
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Material 아이콘 사용하기 위한 용도 -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lamp Games - Review & Play Games!!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 개인용 css 파일 -->
    <link rel="stylesheet" type="text/css" media="screen" href="/main.css" />
    <!-- html 각각 관리(navbar, footer 등) -->
    <script src="/shareHTML/includeHTML.js"></script>
</head>

<body>
    <header>
        <!-- 네비게이션 바 -->
        <nav include-html="/shareHTML/nav.html"> </nav>
    </header>
    <main>
        <!-- <div class="parallax-container">
                <div class="parallax"><img src="images/gowtestimage.jpg"></div>
            </div> -->
        <div class="container">
            <p>내 정보</p>
            <p>id : <?php echo $_SESSION['user_id']; ?></p>
            <p>닉네임 : <?php echo $_SESSION['nickName']; ?></p>
        </div>

        <footer include-html="/shareHTML/footer.html"> </footer>

        <!-- HTML 공통 파일 포함 -->
        <script>
            includeHTML();
        </script>
    </main>
</body>

</html>