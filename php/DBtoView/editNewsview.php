<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/php/connectDB.php';
$listidx = $_GET['listidx'];

$query = 'SELECT * FROM reviewList WHERE listidx = ' . $listidx;
$result_sql = mysqli_query($conn, $query);
if (mysqli_num_rows($result_sql) > 0) {
    $row = mysqli_fetch_assoc($result_sql);
    echo '
    <form action="/php/DBcommand/editNews.php" method="POST" id="news_edit" enctype="multipart/form-data">
        <div class="row">
            <div class="col s12">
                <div class="col s12">
                    <h5 class="center">이미지 미리보기</h5>
                    <img class="materialboxed" id="img" style="display: block; margin-left: auto; margin-right: auto; width: 50%;" src="' . $row['mainimg'] . '">
                </div>
            </div>
            <div class="col s12">
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Image</span>
                        <input type="file" id="uploadImage" name="d_file" accept="image/jpeg, image/png, image/jpg">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" id="uploadpath" type="text" name="mainimage" value="' . $row['mainimg'] . '">
                    </div>
                </div>
            </div>

            <input type="hidden" id="listidx" name="listidx" value="' . $row['listidx'] . '">
            <div class="col s12">
                <div class="input-field col s9">
                    <input placeholder="제목을 입력하세요." id="title" name="title" type="text" class="validate" value="' . $row['title'] . '">
                    <label for="title">Title</label>
                </div>
                <div class="input-field col s3">
                    <input placeholder="카테고리" id="category" name="category" type="text" class="validate" value="' . $row['ref'] . '">
                    <label for="category">Category</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
                    <textarea placeholder="내용을 입력하세요." id="content" name="content" class="materialize-textarea">' . $row['content'] . '</textarea>
                    <label for="content">Content</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <button class="waves-effect waves-light btn col s3 offset-s1" id="historyback">돌아가기</button>
                <button class="waves-effect waves-light btn col s3 offset-s3" id="submit" type="submit">수정완료</button>
            </div>
        </div>
    </form>
    ';
} else {
    echo '
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title center"><h4 id="notfound">글을 찾을 수 없습니다.</h4></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
                <div class="col s12">
                    <button class="waves-effect waves-light btn col s6 offset-s3" id="historyback">돌아가기</button>
                </div>
            </div>
     ';
}
