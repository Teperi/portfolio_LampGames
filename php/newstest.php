<?php
// 에러가 날 경우 에러로그 출력
error_reporting(E_ALL);
ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/php/simplehtmldom/simple_html_dom.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/php/connectDB.php';
// 현재 날짜 받기
date_default_timezone_set("Asia/Seoul");
$today = 20190128;

$folder = $_SERVER["DOCUMENT_ROOT"] . '/savenews/' . ($today - 1);


for ($i = 0; $i < 1; $i++) {
    $html = file_get_html($folder . '/' . $i . '.html');

    // DB 에 넣을 변수 정리
    // 제목, 메인이미지, 날짜, 카테고리, 원본기사URL, 미리보기text, content 순서
    $titleDB ="";
    $mainimgDB = "";
    $dateDB = "";
    $refDB = "게임메카";
    $refurlDB = "";
    $precontentDB = "";
    $contentDB = "";

    // 제목
    echo $titleDB = trim($html->find('div.news_headline h4', 0)->plaintext);
    echo '<br>';
    // 기사입력일시
    $dateText = str_replace("기사입력 ","", trim($html->find('div.news_headline div.info span', 0)->plaintext));

    if(strpos($dateText,"오전")){// 오전일 경우
        echo $dateDB = str_replace(".","-",str_replace("오전 ","",$dateText)). ":00";
    } else { // 오후일 경우 시간에 +12 붙여서 정리
        $newsdate = substr($dateText,0,10);
        $newshour = substr($dateText,18,2) + 12;
        $newsmin = substr($dateText,20,3);
        echo $dateDB = str_replace(".","-",$newsdate)." ".$newshour.$newsmin. ":00";
    }

    echo '<br>';
    // 원본링크
    echo $refurlDB = $html->find('div.news_headline div.info a.press_link', 0)->href;
    echo '<br>';
    // 대표사진주소
    echo $mainimgDB = $html->find('div.news_end div div figure span.end_photo_org img',0)->src;
    echo '<br>';

    //precontent 를 위한 부분
    $textcontent = "";
    //본문 가져오기
    foreach($html->find('div.news_end div') as $value){
        if (sizeof($value->find('img.imageLazyLoad'))) { // 만약 img 태그 중 lazy-load 가 걸려있다면
            foreach ($value->find('img.imageLazyLoad') as $v) {
                // 갯수만큼 가져오는데, src 를 가져올 경우 네이버 서버 내에서 가져오므로 가져올 수 없다
                // 따라서 lazy-src 를 가져온다
                $contentDB = $contentDB.'
                <p align="center"><img style="width: 480px;height=auto" src="'.$v->getAttribute('lazy-src').'"></p>';
            } 
        } elseif(sizeof($value->find('img'))) { // 만약 lazy-load 가 없는 그림이라면
            foreach ($value->find('img') as $v) {
                // src 를 그대로 가져온다
                $contentDB = $contentDB.'
                <p align="center"><img style="width: 480px;height=auto" src="'.$v->src.'"></p>';
                $contentDB = $contentDB.'<p align="center">'.$value->plaintext.'</p><p><br></p>';
            } 
        } elseif (sizeof($value->find('figure iframe'))) { // 만약 동영상이라면
            foreach ($value->find('figure iframe') as $v) {
                // 동영상 주소를 가져온다.
                $contentDB = $contentDB.'
                <p align="center"><iframe src="'.$v->src.'" class="note-video-clip" width="640" height="360" frameborder="0"></iframe></p>';
            } 
            // 동영상 설명은 1개이므로 1개를 가져오면 된다.
            $contentDB = $contentDB.'<p align="center">'.$value->plaintext.'</p><p><br></p>';
        } else {// 내용 텍스트라면
                $contentDB = $contentDB.'<p align="left">'.$value->plaintext.'</p><p><br></p>';
                $textcontent = $textcontent." ".$value->plaintext;
          
        }
    }
//precontent
echo $contentDB;
    //precontent
    echo $precontentDB = iconv_substr($textcontent,0,200, "utf-8");

    $titleDB =str_replace("'", "\'", $titleDB);
    $refDB = "게임메카";
    $precontentDB = str_replace("'", "\'", $precontentDB);
    $contentDB = str_replace("'", "\'", $contentDB);


     //sql 쿼리문 만들기
     $sql = "INSERT INTO reviewList (
        title,
        mainimg,
        reg_date,
        ref,
        refurl,
        precontent,
        content)
        SELECT * FROM ( SELECT
            '" . $titleDB . "',
            '" . $mainimgDB . "',
            '" . $dateDB . "',
            '" . $refDB . "',
            '" . $refurlDB . "',
            '" . $precontentDB . "',
            '" . $contentDB . "'
        ) AS tmp
        WHERE NOT EXISTS (SELECT * FROM reviewList WHERE title = '" . $titleDB . "') LIMIT 1";
        // 쿼리문 실행 및 결과 출력
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "New record created successfully<br>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            break;
        }

    // php 메모리 부하가 올 수 있으므로 다 쓴 html 문서는 메모리에서 삭제시킨다.
    $html->clear();
    unset($html);
}

?>