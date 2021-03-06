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
    <title>Lamp Games - news & Play Games!!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 개인용 css 파일 -->
    <link rel="stylesheet" type="text/css" media="screen" href="/login.css" />

</head>

<body class="yellow lighten-2">
    <div class="container">
        <div class="row"></div>
        <div class="valign-wrapper row">
            <div class="card col s10 pull-s1 m8 pull-m2 l6 pull-l3 hoverable">
                <form action="/php/signupDB.php" onsubmit="return comfirmcomplete();" method="POST" id="signupForm">
                    <div class="card-content">

                        <span class="card-title center dohyeon-font">회원 가입</span>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">person</i>
                                <input id="id" name="id" type="text" autocomplete="off" class="validate" autofocus>
                                <label for="id">ID</label>
                                <span id="iderror" class="helper-text"></span>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">mail_outline</i>
                                <input id="email" name="email" type="text" autocomplete="off" class="validate">
                                <label for="email">E-mail</label>
                                <span id="emailerror" class="helper-text"></span>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">person</i>
                                <input id="nickName" name="nickName" type="text" autocomplete="off" class="validate">
                                <label for="nickName">닉네임</label>
                                <span id="nickNameerror" class="helper-text"></span>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">lock_outline</i>
                                <input id="passwordFirst" name="passwordFirst" type="password" class="validate">
                                <label for="passwordFirst">비밀번호</label>
                                <span id="passwordFirsterror" class="helper-text"></span>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">lock_outline</i>
                                <input id="passwordConfirm" name="passwordConfirm" type="password" class="validate">
                                <label for="passwordConfirm">비밀번호 확인</label>
                                <span id="passwordConfirmerror" class="helper-text"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="input-field col s6">
                            <button id="submit" class="btn disabled waves-effect waves-light col s12 jua-font" type="submit" name="action">회원 가입</button>
                        </div>
                        <div class="input-field col s6">
                            <button class="btn waves-effect waves-light col s12 jua-font" type="reset" name="action" onclick="resettext()">초기화</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 회원 가입 양식 확인용 js -->
    <script src="/js/signup.js" charset="utf-8"></script>
</body>

</html>