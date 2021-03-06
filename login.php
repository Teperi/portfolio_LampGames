<!DOCTYPE html>
<html>
  <?php session_start();
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-1800, '/');
}
?>

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
    <title>로그인 - Lamp Games</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- 개인용 css 파일 -->
    <link rel="stylesheet" type="text/css" media="screen" href="/login.css" />
    <script src="/js/materializecss.js"></script>
  </head>

  <body class="yellow lighten-2">
    <div class="container">
      <div class="valign-wrapper row login-box">
        <div class="card hoverable col s10 pull-s1 m8 pull-m2 l6 pull-l3 ">
          <form method="POST" action="/php/loginDB.php">
            <div class="card-content">
              <span class="card-title center dohyeon-font">로그인</span>
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">person</i>
                  <input id="id" name="id" type="text" class="validate" required />
                  <label for="id">ID</label>
                </div>
                <div class="input-field col s12">
                  <i class="material-icons prefix">lock_outline</i>
                  <input id="password" name="password" type="password" class="validate" required />
                  <label for="password">비밀번호</label>
                </div>
                <div class="input-field col s12">
                  <p>
                    <label>
                      <input type="checkbox" id="rememberme" name="rememberme" />
                      <span class="blue-grey-text text-darken-4">로그인 정보 기억하기</span>
                    </label>
                  </p>
                </div>
              </div>
            </div>

            <div class="card-action">
              <div class="row">
                <button
                  class="btn waves-effect waves-light col s12 jua-font"
                  type="submit"
                  name="action"
                >
                  로그인
                </button>
              </div>
              <div>
                <p>
                  <a href="/signup.php" class="blue-text text-darken-2">회원가입</a>
                  <a
                    href="/index.php"
                    class="right blue-text text-darken-2"
                    style="margin-right: 0"
                  >
                    홈으로
                  </a>
                </p>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
