<!DOCTYPE html>
<html>
<?php session_start();
?>
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
    <link rel="stylesheet" type="text/css" media="screen" href="/list.css" />
    <!-- html 각각 관리(navbar, footer 등) -->
    <script src="../shareHTML/includeHTML.js"></script>

</head>

<body>
    <header>
        <!-- 네비게이션 바 -->
        <nav include-html="/shareHTML/nav.php"> </nav>
    </header>
    <main>
        <div class="container">
            <blockquote class="dohyeon-font">
                <h1>Review</h1>
            </blockquote>
            <div class="row" id="reviewlist">
                    <!-- 게시판 리스트 -->
                    <div class="col s12" id="test">
                    <?php
                     $limitNumber = 0;
                        require_once $_SERVER["DOCUMENT_ROOT"].'/php/reviewList.php';
                    ?>
                    </div>

                    <div class="col s12">
                        <button id="more" name="more" class='waves-effect btn-flat indigo white-text hoverable col s12' onclick=myFunction()>더보기</button>
                    </div>
                    
            </div>
        </div>

        <script>
            var add = (function () {
                var counter = 0;
                    return function () {return counter += 1;}
                })();

                function myFunction(){
                    var countNum = add();
                    document.getElementById('more').classList.add('disabled');
                    sendcountnum(countNum, resultout);
                }
                
                // 닉네임 중복 확인 데이터 가져오기
                function sendcountnum(number, callback) {
                    var data = 'morecount=' + number;
                    var xhr = new XMLHttpRequest();
                    var url = "/php/reviewList.php"
                    xhr.onreadystatechange = function() {
                        if (this.readyState === 4 && this.status === 200) {
                            callback(this);
                        }
                    }
                    xhr.open('POST', url);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                    xhr.send(data);
                }

                function resultout(xhttp) {
                    if(xhttp.responseText.length !=4) {
                        document.getElementById('test').innerHTML += xhttp.responseText;
                        document.getElementById('more').classList.remove('disabled');
                        // var card = document.createElement("div");
                        // card.classList.add("col");
                        // card.classList.add("s12");
                        parser = new DOMParser();
                        htmlDoc = parser.parseFromString(xhttp.responseText,"text/html");
                        console.log(htmlDoc.body.innerText.trim());
                        // card.appendChild(htmlDoc.body.innerHTML);
                        // document.getElementById('test').appendChild(htmlDoc.body.innerHTML);
                    }  
                }
        </script>


        <footer include-html="../shareHTML/footer.php"> </footer>
        <!-- HTML 공통 파일 포함 -->
        <script>
            includeHTML();
        </script>
    </main>

</body>

</html>