<?php session_start();
if($_SESSION['user_id'] != 'admin' || !isset($_SESSION['user_id'])){
    header("HTTP/1.0 404 Not Found");
    exit();
}
?>
<!DOCTYPE html>
<html>

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
    <link rel="stylesheet" type="text/css" media="screen" href="/list.css" />
    <!-- html 각각 관리(navbar, footer 등) -->
    <script src="/shareHTML/includeHTML.js"></script>
    <script src="/js/materializecss.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.js" integrity="sha256-fNXJFIlca05BIO2Y5zh1xrShK3ME+/lYZ0j+ChxX2DA=" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <!-- 네비게이션 바 -->
        <nav include-html="/shareHTML/nav.php"> </nav>
    </header>
    <main>
        <ul id="slide-out" class="sidenav" include-html="/shareHTML/sidebar.php">
        </ul>
        <div class="container">
            <blockquote class="dohyeon-font">
                <h3>뉴스 작성</h3>
            </blockquote>
            <div id="editnews">
                <form action="/php/DBcommand/newNews.php" method="POST" id="news_New" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col s12">
                            <div class="col s12">
                                <h5 class="center">이미지 미리보기</h5>
                                <img class="materialboxed" id="img" style="display: block; margin-left: auto; margin-right: auto; width: 50%;" src="">
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>Image</span>
                                    <input type="file" id="uploadImage" name="d_file" accept="image/jpeg, image/png, image/jpg">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" id="uploadpath" type="text" name="mainimage" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="input-field col s9">
                                <input placeholder="제목을 입력하세요." id="title" name="title" type="text" class="validate" value="">
                                <label for="title">Title</label>
                            </div>
                            <div class="input-field col s3">
                                <input placeholder="카테고리" id="category" name="category" type="text" class="validate" value="">
                                <label for="category">Category</label>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="input-field col s12">
                                <textarea placeholder="내용을 입력하세요." id="content" name="content" class="materialize-textarea"></textarea>
                                <label for="content">Content</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <button class="waves-effect waves-light btn col s6 offset-s3" id="submit" type="submit">수정완료</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <script>
        </script>


        <footer include-html="../shareHTML/footer.php"> </footer>
        <!-- HTML 공통 파일 포함 -->
        <script>
            includeHTML();
        </script>

        <script>
            var sel_file;

            $(document).ready(function() {
                $("#uploadImage").on("change", handleImgFileSelect);
            });

            function handleImgFileSelect(e) {
                var files = e.target.files;
                var filesArr = Array.prototype.slice.call(files);

                filesArr.forEach(function(f) {
                    if (!f.type.match("image.*")) {
                        alert("확장자는 이미지 확장자만 가능합니다.");
                        return;
                    }

                    sel_file = f;

                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("#img").attr("src", e.target.result);
                    }
                    reader.readAsDataURL(f);
                });
            }
        </script>

        <script>
            let titletext = document.getElementById("title");
            let contenttext = document.getElementById("content");
            let image = document.getElementById("uploadImage");
            let imagepath = document.getElementById("uploadpath");
            let backbutton = document.getElementById("historyback");
            let submitbutton = document.getElementById("submit")

            imagepath.addEventListener('change', function() {
                console.log(image.value);
            });

            function sendcountnum(number, callback) {
                var data = 'morecount=' + number;
                var xhr = new XMLHttpRequest();
                var url = "/php/DBtoView/newsList.php";
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
                if (xhttp.responseText.length != 4) {
                    document.getElementById('newsList').innerHTML += xhttp.responseText;
                    document.getElementById('more').classList.remove('disabled');
                    // TODO: 마지막 리스트 출력 이후 더보기 disabled 기능 출력
                }
            }
        </script>

    </main>

</body>

</html>