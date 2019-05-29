<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/php/connectDB.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $getimage = $_POST['mainimage'];
    $gettitle = $_POST['title'];
    $gettitle = str_replace("'", "\'", $gettitle);
    $getcontent = $_POST['content'];
    $getcontent = str_replace("'", "\'", $getcontent);
    $precontent = $_POST['precontent'];
    $precontent = str_replace("'", "\'", $precontent);
    date_default_timezone_set('Asia/Seoul');
    $dateString = date("Y-m-d H:i:s", time());
    $path;
    if (isset($_FILES['d_file']['tmp_name'])) {
        $tmpfile = $_FILES['d_file']['tmp_name'];
        $o_name = $_FILES['d_file']['name'];
        $folder = $_SERVER["DOCUMENT_ROOT"] . '/images';
        $path = "$folder/$o_name";

        //폴더 체크 후 생성
        if (!is_dir($folder)) {
            mkdir($folder);
        }

        move_uploaded_file($_FILES['d_file']['tmp_name'], $path);
    }

    $getcategory = $_POST['category'];

    $sql = 'INSERT INTO reviewList (
        title,
        mainimg,
        reg_date,
        ref,
        precontent,
        content)
    VALUES (
        \'' . $gettitle . '\',
        \'' . '/images/' . $_FILES['d_file']['name'] . '\',
        \'' . $dateString . '\',
        \'' . $getcategory . '\',
        \'' . $precontent . '\',
        \'' . $getcontent . '\'
        )
    ';
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>
                alert('\"$gettitle\" \\등록이 완료되었습니다.');
                document.location.href='/news/news.php'
            </script>";
    } else {
        echo "<script>
                alert('오류가 발생했습니다. \\n다시 등록해 주세요.');
                history.back();
            </script>";
    }

}
