<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/php/connectDB.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $getidx = $_POST['listidx'];
    $getimage = $_POST['mainimage'];
    $gettitle = $_POST['title'];
    $gettitle = str_replace("'", "\'", $gettitle);
    $getcontent = $_POST['content'];
    $getcontent = str_replace("'", "\'", $getcontent);
    $precontent = iconv_substr($getcontent, 0, 60, "utf-8");
    $precontent = str_replace("<div style=\"text-align: justify;\" align=\"justify\">", " ", $precontent);
    $precontent = str_replace("<\/div>", " ", $precontent);
    $precontent = str_replace("<br>", " ", $precontent);
    date_default_timezone_set('Asia/Seoul');
    $dateString = date("Y-m-d H:i:s", time());

    $getcategory = $_POST['category'];
    if (isset($_FILES['d_file']['tmp_name'])) {
        $tmpfile = $_FILES['d_file']['tmp_name'];
        $o_name = $_FILES['d_file']['name'];
        $folder = $_SERVER["DOCUMENT_ROOT"] . '/images';
        $path = "$folder/$o_name";

        //폴더 체크 후 생성
        if (!is_dir($folder)) {
            mkdir($folder);
        }

        $fileupload = move_uploaded_file($_FILES['d_file']['tmp_name'], $path);
    }
    if ($fileupload) {
        $sql = 'UPDATE reviewList
        SET title = \'' . $gettitle . '\',
            content = \'' . $getcontent . '\',
            precontent = \'' . $precontent . '\',
            reg_date = \'' . $dateString . '\',
            ref = \'' . $getcategory . '\',
            mainimg = \'' . '/images/' . $_FILES['d_file']['name'] . '\'
        WHERE listidx = \'' . $getidx . '\'';
    } else {
        $sql = 'UPDATE reviewList
        SET title = \'' . $gettitle . '\',
            content = \'' . $getcontent . '\',
            precontent = \'' . $precontent . '\',
            reg_date = \'' . $dateString . '\',
            ref = \'' . $getcategory . '\'
        WHERE listidx = \'' . $getidx . '\'';
    }

    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>
                alert('\"$gettitle\" \\n수정이 완료되었습니다.');
                document.location.href='/news/news_content.html?listidx=$getidx'
            </script>";
    } else {
        echo "<script>
                alert('오류가 발생했습니다. \\n다시 수정해 주세요.');
                history.back();
            </script>";
    }
}
