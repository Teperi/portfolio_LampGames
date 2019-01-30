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
    $html = file_get_html($folder . '/' . $i . '.html');
    // 제목
    echo $title = trim($html->find('div.news_headline h4', 0)->plaintext);
    echo '<br>';
    // 기사입력일시
    echo trim($html->find('div.news_headline div.info span', 0)->plaintext);
    echo '<br>';
    // 원본링크
    echo $html->find('div.news_headline div.info a.press_link', 0)->href;
    echo '<br>';
    // 대표사진주소
    echo $html->find('div.news_end div div figure span.end_photo_org img',0)->src;
    echo '<br>';
    //본문 가져오기
    foreach($html->find('div.news_end div') as $value){
        if (sizeof($value->find('div figure span.end_photo_org img.imageLazyLoad'))) { // 만약 img 태그 중 lazy-load 가 걸려있다면
            foreach ($value->find('div figure span.end_photo_org img.imageLazyLoad') as $v) {
                // 갯수만큼 가져오는데, src 를 가져올 경우 네이버 서버 내에서 가져오므로 가져올 수 없다
                // 따라서 lazy-src 를 가져온다
                echo $v->getAttribute('lazy-src');
                echo '<br>';
            } 
        } elseif(sizeof($value->find('div figure span.end_photo_org img'))) { // 만약 lazy-load 가 없는 그림이라면
            foreach ($value->find('div figure span.end_photo_org img') as $v) {
                // src 를 그대로 가져온다
                echo $v->src;
                echo '<br>';
            } 
        } elseif (sizeof($value->find('figure iframe'))) { // 만약 동영상이라면
            foreach ($value->find('figure iframe') as $v) {
                // 동영상 주소를 가져온다.
                echo $v->src;
                echo '<br>';
            } 
            // 동영상 설명은 1개이므로 1개를 가져오면 된다.
            echo $value->plaintext.' : 동영상설명';
            echo '<br>';
        } else {
            if(sizeof($value->find('img'))){ // 이미지 태그에 들어간 글이라면
                if(strlen($value->plaintext)>0){
                    echo $value->plaintext.' : 그림설명';
                    echo '<br>';
                }
            } else { // 내용 텍스트라면
                echo $value->plaintext;
                echo '<br>';
            }
        }
    }
    // php 메모리 부하가 올 수 있으므로 다 쓴 html 문서는 메모리에서 삭제시킨다.
    $html->clear();
    unset($html);
}

?>