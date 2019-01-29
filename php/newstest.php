<?php
// 에러가 날 경우 에러로그 출력
error_reporting(E_ALL);
ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/php/simplehtmldom/simple_html_dom.php';
// 현재 날짜 받기
date_default_timezone_set("Asia/Seoul");
$today = 20190128;

$folder = $_SERVER["DOCUMENT_ROOT"] . '/savenews/' . ($today - 1);


for ($i = 0; $i < 1; $i++) {
    // clean up memory
    
    $html = file_get_html($folder . '/' . $i . '.html');
    // 제목
    echo trim($html->find('div.news_headline h4', 0)->plaintext);
    echo '<br>';
    // 기사입력일시
    echo trim($html->find('div.news_headline div.info span', 0)->plaintext);
    echo '<br>';
    // 원본링크
    echo $html->find('div.news_headline div.info a.press_link', 0)->href;
    echo '<br>';
    // 대표사진링크
    echo $html->find('div.news_end div div figure span.end_photo_org img',0)->src;
    echo '<br>';
    //본문 가져오기
    foreach($html->find('div.news_end div') as $value){
        if(sizeof($value->find('div figure'))) {
            foreach ($value->find('div figure') as $v) {
                echo $v->src;
                echo $v->plaintext;
                echo '<br>';
            }
        } else {
            if(sizeof($value->find('img'))){

            } else {
                echo $value->plaintext;
                echo '<br>';
            }
        }
    }

    $html->clear();
    unset($html);
    }

?>