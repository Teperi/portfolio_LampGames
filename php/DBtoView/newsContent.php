<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/php/connectDB.php';
$listidx = $_GET['listidx'];

$query = 'SELECT * FROM reviewList WHERE listidx = ' . $listidx;
$result_sql = mysqli_query($conn, $query);
if (mysqli_num_rows($result_sql) > 0) {
    $row = mysqli_fetch_assoc($result_sql);
    $categoryColor;
    if ($row['ref'] == '게임메카') {
        $categoryColor = 'blue';
    } else {
        $categoryColor = 'purple';
    }

    echo '
    <main>
        <div class="parallax-container">
            <div class="parallax"><img src="' . $row['mainimg'] . '"></div>
        </div>
        <div class="section" id="top">
            <div class="row container">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title"><h3>' . $row['title'] . '</h3></span>
                            <br>
                            <p class="blue-grey-text text-accent-2 right-align"><span>' . $row['ref'] . '</span> <span>  ' . $row['reg_date'] . '</span> </p>
                            <hr>
                            <div id="newsList_content">
                                ' . $row['content'] . '
                            </div>
                        </div>
                        <div class="card-action dohyeon-font">
                            <div class="chip ' . $categoryColor . ' white-text truncate" id="newsList_category2">' . $row['ref'] . '</div>

                        </div>
                    </div>

                </div>
                <div class="col s12">
                    <a href="/news/news.html" class="waves-effect waves-light btn col s4 push-s1 teal lighten-2 dohyeon-font">뉴스 페이지로 돌아가기</a>
                    <a href="#top" class="waves-effect waves-light btn col s4 push-s3 teal lighten-2 dohyeon-font">맨 위로 올라가기</a>
                </div>
            </div>
        </div>
    </main>';

} else {
    echo '
    <main>
        <div class="row container">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title center"><h4>글을 찾을 수 없습니다.</h4></span>
                        <hr>
                        <div id="newsList_content">
                            <p class="center-align">
                                <a href="/news/news.html" class="waves-effect waves-light btn teal lighten-2 dohyeon-font">리뷰 페이지로 돌아가기</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>';
}
