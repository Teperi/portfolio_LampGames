<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/php/connectDB.php';
$query;
$rowcount;
if (isset($_POST['morecount'])) {
    $limitNumber = $_POST['morecount'];
    $query = 'SELECT * FROM reviewList ORDER BY reg_date DESC LIMIT ' . (20 * $limitNumber) . ',' . 20;
    $rowcount = 'SELECT COUNT(listidx) AS rowNum FROM reviewList';
} else {
    $query = 'SELECT * FROM reviewList ORDER BY reg_date DESC LIMIT 20';
    $rowcount = 'SELECT COUNT(listidx) AS rowNum FROM reviewList';
}

$result_sql = mysqli_query($conn, $query);
if (mysqli_num_rows($result_sql) > 0) {
    while ($row = $result_sql->fetch_assoc()) {
        $categoryColor;
        if ($row['ref'] == '게임메카') {
            $categoryColor = 'blue';
        } else {
            $categoryColor = 'purple';
        }

        $text = str_replace("'", "\'", $row['title']);
        $text = str_replace(",", "\,", $text);

        echo '<li class="collection-item avatar">
                <img src="' . $row['mainimg'] . '" class="circle">
                <span class="title">' . $row['title'] . '</span><br>
                <p class="truncate">' . $row['reg_date'] . '
                </p><br>
                <p class="truncate">' . $row['precontent'] . '
                </p><br>

                <a href="/news/news_content.php?listidx=' . $row['listidx'] . '" class="waves-effect waves-light btn-small">글 본문 보기</a>
                <a href="/news/news_edit.php?listidx=' . $row['listidx'] . '" class="waves-effect waves-light btn-small">글 수정</a>
                <button class="waves-effect waves-light btn-small" onClick="clickdelete(' . $row['listidx'] . ', \'' . $text . '\')">글 삭제</button>
                <label class="secondary-content">
                    <input type="checkbox" id="' . $row['listidx'] . '" name="checkbox" class="checkbox"/>
                    <span></span>
                </label>
            </li>
            ';
    }
}
