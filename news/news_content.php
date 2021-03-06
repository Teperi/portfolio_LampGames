<!DOCTYPE html>
<html>
  <?php session_start(); ?>

  <head>
    <meta charset="utf-8" />
    <!-- Compiled and minified CSS -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
    />
    <!-- Material 아이콘 사용하기 위한 용도 -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Lamp Games - news & Play Games!!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- 개인용 css 파일 -->
    <link rel="stylesheet" type="text/css" media="screen" href="/main.css" />
    <!-- html 각각 관리(navbar, footer 등) -->
    <script src="/shareHTML/includeHTML.js"></script>
    <!-- 이미지박스 처리 -->
    <script src="/js/materializecss.js"></script>
  </head>

  <body>
    <header>
      <!-- 네비게이션 바 -->
      <nav include-html="/shareHTML/nav.php"></nav>
    </header>
    <ul id="slide-out" class="sidenav" include-html="/shareHTML/sidebar.php"></ul>

    <?php 
        include $_SERVER["DOCUMENT_ROOT"].'/php/DBtoView/newsContent.php';
    ?>

    <footer include-html="/shareHTML/footer.php"></footer>
    <!-- HTML 공통 파일 포함 -->
    <script>
      includeHTML();
    </script>
  </body>
</html>
