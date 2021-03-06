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
    <link rel="stylesheet" type="text/css" media="screen" href="/list.css" />
    <!-- 개인용 css 파일 -->
    <link rel="stylesheet" type="text/css" media="screen" href="/news/news.css" />
    <!-- html 각각 관리(navbar, footer 등) -->
    <script src="/shareHTML/includeHTML.js"></script>
    <script src="/js/materializecss.js"></script>
    <!-- include libraries(jQuery, bootstrap) -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

    <!-- include summernote css/js -->
    <link href="/summernote_dist/summernote-lite.css" rel="stylesheet" />
    <script src="/summernote_dist/summernote-lite.min.js"></script>
    <!-- include summernote-ko-KR -->
    <script src="/summernote_dist/lang/summernote-ko-KR.js"></script>
  </head>

  <body>
    <header>
      <!-- 네비게이션 바 -->
      <nav include-html="/shareHTML/nav.php"></nav>
    </header>
    <main>
      <ul id="slide-out" class="sidenav" include-html="/shareHTML/sidebar.php"></ul>
      <div class="container">
        <blockquote class="dohyeon-font">
          <h3>뉴스 수정</h3>
        </blockquote>
        <div id="editnews">
          <?php include $_SERVER["DOCUMENT_ROOT"].'/php/DBtoView/editNewsview.php';?>
        </div>
      </div>

      <script></script>

      <footer include-html="../shareHTML/footer.php"></footer>
      <!-- HTML 공통 파일 포함 -->
      <script>
        includeHTML();
      </script>

      <script>
        //예외처리용 변수 (뒤로가기 방지)
        let titleclick = true;
        let categoryclick = false;
        let contentclick = false;
        let precontentclick = false;

        // 이미지 업로드용 변수
        var sel_file;

        $(document).ready(() => {
          // 내용 text 를 summernote 로 삽입
          $('#content').summernote({
            lang: 'ko-KR',
            placeholder: '내용을 입력하세요.',
            height: 500,
            callbacks: {
              onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);
              }
            }
          });
          // 리셋 버튼을 누르면 summernote 내 내용도 같이 reset 되도록 함
          // 그냥 form reset 는 summernote 외 다른 내용만 reset 시킴
          $('#reset').click(() => {
            $('#content').summernote('reset');
            $('#img').attr('src', '');
            $('h5').css('display', 'none');
          });
          // 작성 취소를 누르면 뒤로 돌아가도록 설정
          $('#backbutton').click(() => {
            window.history.back();
          });

          // focus 와 blur 되었을 때 각각의 변수에 T/F 제공
          // 이렇게 한 이유: 보통 글 작성시 뒤로가기 버튼을 막는 용도(예외처리)

          $('#title').focus(() => {
            titleclick = true;
            console.log('title : ' + titleclick);
          });
          $('#category').focus(() => {
            categoryclick = true;
            console.log('category : ' + categoryclick);
          });
          $('#precontent').focus(() => {
            precontentclick = true;
            console.log('precontent : ' + precontentclick);
          });
          $('#content').on('summernote.focus', function() {
            contentclick = true;
            console.log('content : ' + contentclick);
          });
          $('#title').blur(() => {
            titleclick = false;
            console.log('title : ' + titleclick);
          });
          $('#category').blur(() => {
            categoryclick = false;
            console.log('category : ' + categoryclick);
          });
          $('#precontent').blur(() => {
            precontentclick = false;
            console.log('precontent : ' + precontentclick);
          });
          $('#content').on('summernote.blur', function() {
            contentclick = false;
            console.log('content : ' + contentclick);
          });
          $('#content').blur(() => {
            contentclick = false;
            console.log('content : ' + contentclick);
          });

          // 기본 포커스는 title 에 놓음
          $('#title').focus();

          // 만약 3곳에서 포커스가 모두 빠졌을 경우 뒤로가기(backspace) 방지
          $(document).bind('keydown', function(e) {
            if (
              e.keyCode == 8 &&
              !titleclick &&
              !categoryclick &&
              !contentclick &&
              !precontentclick
            ) {
              // backspace 방지
              e.preventDefault();
            }
          });

          //summernote 내 이미지 처리
          //

          function sendFile(files, editor, welEditable) {
            var form_data = new FormData();
            form_data.append('file', files);
            $.ajax({
              data: form_data,
              type: 'POST',
              url: '/php/DBcommand/contentImageUpload.php',
              cache: false,
              contentType: false,
              processData: false,
              success: function(url) {
                $('#content').summernote('editor.insertImage', url);
                console.log(url);
              }
            });
          }

          //
          //대표 이미지미리보기 js
          //

          $('#uploadImage').on('change', handleImgFileSelect);

          function handleImgFileSelect(e) {
            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);

            filesArr.forEach(function(f) {
              if (!f.type.match('image.*')) {
                alert('확장자는 이미지 확장자만 가능합니다.');
                return;
              }

              sel_file = f;

              var reader = new FileReader();
              reader.onload = function(e) {
                $('#img').attr('src', e.target.result);
                $('h5').css('display', 'block');
              };
              reader.readAsDataURL(f);
            });
          }
        });
      </script>
    </main>
  </body>
</html>
