<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/php/connectDB.php';
$query;
$rowcount;
if (isset($_POST['morecount'])) {
    $limitNumber = $_POST['morecount'];
    $query = 'SELECT * FROM reviewList ORDER BY reg_date DESC LIMIT ' . (5 * $limitNumber) . ',' . 5;
    $rowcount = 'SELECT COUNT(listidx) AS rowNum FROM reviewList';
} else {
    $query = 'SELECT * FROM reviewList ORDER BY reg_date DESC LIMIT 5';
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

        echo '<a href="/news/news_content.php?listidx=' . $row['listidx'] . '">
                    <div class="card horizontal hoverable cardHorizen">
                        <div class="card-image col s3" style="padding:0px">
                            <img src="' . $row['mainimg'] . '" class="cardHorizenImg">
                        </div>
                        <div class="card-stacked col s9 truncate">
                            <div class="card-content">
                                <span class="card-title grey-text text-darken-4 dohyeon-font truncate" id="newsList_title">' . $row['title'] . '</span>
                                <p class="grey-text text-darken-4 truncate">' . $row['precontent'] . '</p>
                            </div>
                            <div class="card-action dohyeon-font">
                                <div class="chip ' . $categoryColor . ' white-text truncate">' . $row['ref'] . '</div>
                                <div class=" truncate right-align grey-text text-darken-4" style="font-size:small">' . $row['reg_date'] . '</div>
                            </div>
                        </div>
                    </div>
                </a>
            ';
    }
}
