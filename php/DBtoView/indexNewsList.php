<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/php/connectDB.php';

$sql = 'SELECT * FROM reviewList ORDER BY reg_date DESC limit 4';
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        $categoryColor;
        if ($row['ref'] == '루리웹') {
            $categoryColor = 'blue';
        } else {
            $categoryColor = 'purple';
        }

        echo '<div class="col s12 m6 l3">
            <a href="/news/news_content.html?listidx=' . $row['listidx'] . '">
                <div class="card hoverable">
                    <div class="card-image cardVerticalImgDiv">
                        <img class="cardVerticalImg" src="' . $row['mainimg'] . '">
                    </div>
                    <div class="card-content">
                        <span class="card-title dohyeon-font black-text truncate">' . $row['title'] . '</span>
                        <p class="black-text truncate">' . $row['precontent'] . '</p>
                    </div>
                    <div class="card-action dohyeon-font">
                        <div class="chip ' . $categoryColor . ' white-text truncate">
                            ' . $row['ref'] . '
                        </div>
                    </div>
                </div>
            </a>
        </div>';
    }
}
