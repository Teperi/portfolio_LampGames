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
    <link rel="stylesheet" type="text/css" media="screen" href="/main.css" />


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
            <div class="row">

                <div class="col s12">
                    <ul class="collection with-header" id="newsList">
                        <li class="collection-header">
                            <p>
                                <h4 style="display:inline">뉴스 관리</h4>
                                <a class="waves-effect waves-light btn right" href="/login.php">로그아웃</a>
                            </p>
                        </li>
                        <li class="collection-item">
                            <a id="newNews" href="/news/summernotetest.html" class="waves-effect waves-light btn-small">새 뉴스 기록</a>
                            <button id="deleteCheckNews" class="waves-effect waves-light btn-small disabled"><i class="material-icons">delete</i>선택 삭제</button>
                        </li>
                        <?php include $_SERVER["DOCUMENT_ROOT"] . '/php/DBtoView/sitemasterNewsList.php'; ?>
                    </ul>
                    <div>
                        <button id="more" name="more" class='waves-effect btn-large indigo white-text hoverable col s12' onclick=moreclick()>더보기</button>
                    </div>
                </div>
            </div>

        </div>


        <footer include-html="/shareHTML/footer.php"> </footer>

        <!-- HTML 공통 파일 포함 -->
        <!-- html 각각 관리(navbar, footer 등) -->
        <script src="/shareHTML/includeHTML.js"></script>
        <script src="/js/materializecss.js"></script>
        <script>
            includeHTML();
        </script>
        <script src="/js/sitemaster/sitemasterDelete.js"></script>
        <script src="/js/sitemaster/sitemasterNewsListMore.js"></script>
        <script>
            let deleteChecked = document.getElementById('deleteCheckNews');
            let listidxSave = [];
            document.addEventListener('DOMContentLoaded', function checkbox() {
                // 클래스가 checkbox 라고 된 것을 다 모아서 변수에 담아둠
                var checkboxlist = document.querySelectorAll('.checkbox');
                // 개수만큼 for 실행
                checkboxlist.forEach(element => {
                    // 각각의 checkbox 에 클릭됬을 시 해야할 행동 정해주기
                    element.addEventListener("click", function() {
                        // 만약 체크되어있는 상태였다면
                        if (element.getAttribute('checked')) {
                            // 체크 해제
                            element.removeAttribute('checked');
                            // 체크 해제된 idx 값의 list index 받아오기
                            var idx = listidxSave.indexOf(element.getAttribute('id'));
                            // list 의 index 값 기준 삭제
                            listidxSave.splice(idx, 1);
                            // 삭제버튼 활성화 여부 체크
                            deletebtn(listidxSave.length);
                            console.log(listidxSave.toString());

                            // 만약 체크가 안되있었다면
                        } else {
                            // 체크 설정
                            element.setAttribute('checked', 'checked');
                            // list 에 글 아이디 담기
                            listidxSave.push(element.getAttribute('id'));
                            // 삭제버튼 활성화 여부 체크
                            deletebtn(listidxSave.length);
                            console.log(listidxSave.toString());
                        }
                    })
                });
            });

            function deletebtn(num) {
                if (num == 0) {
                    deleteChecked.classList.add('disabled');
                } else {
                    deleteChecked.classList.remove('disabled');
                }
            }
            document.addEventListener('DOMContentLoaded', function() {
                deleteChecked.addEventListener("click", function() {
                    checkdelete(listidxSave, callbackDelete);
                })
            });
        </script>
    </main>
</body>

</html>s