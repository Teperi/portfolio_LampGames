<?php
include '/var/www/html/php/simplehtmldom/simple_html_dom.php';
require_once '/var/www/html/php/connectDB.php';

// URL 내의 body 페이지를 가져오는 함수
function get_content($url)
{
    $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36';
    $curlsession = curl_init();
    curl_setopt($curlsession, CURLOPT_URL, $url);
    curl_setopt($curlsession, CURLOPT_HEADER, false);
    curl_setopt($curlsession, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curlsession, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlsession, CURLOPT_POST, false);
    curl_setopt($curlsession, CURLOPT_USERAGENT, $agent);
    curl_setopt($curlsession, CURLOPT_REFERER, $url);
    curl_setopt($curlsession, CURLOPT_TIMEOUT, 30);
    $buffer = curl_exec($curlsession);
    $cinfo = curl_getinfo($curlsession);
    curl_close($curlsession);
    if ($cinfo['http_code'] != 200) {
        return "";
    }
    return $buffer;
}
date_default_timezone_set("Asia/Seoul");
// 현재 날짜 받기
// 여기만 바꾸면 날짜별로 가져올수 있음 : here!!
$today = date("Ymd");

// 목록에 있는 href 목록을 가져오기
// 1. 우선 CURL 에 있는 내용을 컴퓨터에 저장
// 여기를 바꾸면 다른 회사것을 가져올 수 있음 : here2!!
$curlfile = get_content('https://news.naver.com/main/list.nhn?mode=LPOD&mid=sec&oid=356&date=' . ($today - 1));
$localfile = fopen('/var/www/html/savenews/' . ($today - 1) . '_list.html', 'w');
fwrite($localfile, $curlfile);
fclose($localfile);

// 2. localfile 에 있는 데이터를 simple htmle dom parser 로 변환해서 상황 보기
// 완전히 저장 된 후 아래 작업 시작을 위해 sleep 적용
sleep(1);
// html 파일을 simple dom parser 를 사용해서 a 태그 안의 href 만 가져옴
$html = file_get_html('/var/www/html/savenews/' . ($today - 1) . '_list.html');
$linklist;
foreach ($html->find('div.list_body li a') as $value) {
    $linklist[] = $value->href;
}
// clean up memory
$html->clear();
unset($html);

// 그냥 news.naver.com 으로 접속하면 curl 에서 에러가 남.
// 쉬운 크롤링을 막기 위한 도구로 확인됨
// 따라서 모든 주소를 원본 기사의 주소로 바꿔줌
// href 가 겹치는 경우를 모두 제거한 후 실제 뉴스 주소에 맞게 바꿈

$newsUrlList;
foreach (array_unique($linklist) as $value) {
    $newsUrlList[] = str_replace("https://news.naver.com/main/read.nhn?mode=LPOD&mid=sec&", "https://sports.news.naver.com/esports/news/read.nhn?", $value);
}

// 3. 주소에 따라 뉴스 내용 html 로 저장하기
// 데이터가 저장될 경로 설정
$folder = '/var/www/html/savenews/gm/' . ($today - 1);

// 위에서 가져온 뉴스 URL 을 크롤링해서 서버에 직접 저장
for ($i = 0; $i < sizeof($newsUrlList); $i++) {
    //curl 파일로 가져오기
    $curlfile = get_content($newsUrlList[$i]);

    //폴더 체크 후 생성
    if (!is_dir($folder)) {
        mkdir($folder);
    }
    //
    $localfile = fopen($folder . '/' . $i . '.html', 'w');
    fwrite($localfile, $curlfile);
    fclose($localfile);
    sleep(1);

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
    $titleDB = trim($html->find('div.news_headline h4', 0)->plaintext);
    // 기사입력일시
    $dateText = str_replace("기사입력 ","", trim($html->find('div.news_headline div.info span', 0)->plaintext));
    if(strpos($dateText,"오전")){// 오전일 경우
        echo $dateDB = str_replace(".","-",str_replace("오전 ","",$dateText)). ":00";
        echo $dateDB;
    } else { // 오후일 경우 시간에 +12 붙여서 정리
        $newsdate = substr($dateText,0,10);
        $newshour = substr($dateText,19,2) + 12;
        $newsmin = substr($dateText,21,3);
        $dateDB = str_replace(".","-",$newsdate)." ".$newshour.$newsmin. ":00";
    }
    // 원본링크
    $refurlDB = $html->find('div.news_headline div.info a.press_link', 0)->href;
    // 대표사진주소
    $mainimgDB = $html->find('div.news_end img',0)->src;

    //precontent 를 위한 부분
    $textcontent = "";
    //본문 가져오기
    //본문 가져오기
    foreach($html->find('div.news_end div') as $value){
        if (sizeof($value->find('img.imageLazyLoad'))) { // 만약 img 태그 중 lazy-load 가 걸려있다면
            foreach ($value->find('img.imageLazyLoad') as $v) {
                if(!strpos($contentDB,$v->getAttribute('lazy-src'))){
                // 갯수만큼 가져오는데, src 를 가져올 경우 네이버 서버 내에서 가져오므로 가져올 수 없다
                // 따라서 lazy-src 를 가져온다
                $contentDB = $contentDB.'<p align="center"><img class="materialboxed" width="480" src="'.$v->getAttribute('lazy-src').'"></p>';
                }
            } 
            // 이미지 아래 설명 가져오기, 없는 경우 pass
            if(!empty($value->plaintext) && !strpos($contentDB,$value->plaintext)){
                $contentDB = $contentDB.'<p align="center">'.$value->find('figcaption',0)->plaintext.'</p><br>';
            }
        } elseif(sizeof($value->find('img'))) { // 만약 lazy-load 가 없는 그림이라면
            foreach ($value->find('img') as $v) {
                if(!strpos($contentDB,$v->src)){
                    // src 를 그대로 가져온다
                    $contentDB = $contentDB.'<p align="center"><img class="materialboxed" width="480" src="'.$v->src.'"></p>';
                }
            } 
            // 이미지 아래 설명 가져오기, 없는 경우 pass
            if(!empty($value->plaintext) && !strpos($contentDB,$value->plaintext)){
                $contentDB = $contentDB.'<p align="center">'.$value->find('figcaption',0)->plaintext.'</p><br>';
            }
        } elseif (sizeof($value->find('figure iframe'))) { // 만약 동영상이라면
            foreach ($value->find('figure iframe') as $v) {
                if(!strpos($contentDB,$v->src)){
                    // 동영상 주소를 가져온다.
                    $contentDB = $contentDB.'<p align="center"><iframe src="'.$v->src.'" class="note-video-clip" width="640" height="360" frameborder="0"></iframe></p>';
                }
            } 
            // 동영상 설명은 1개이므로 1개를 가져오면 된다.
            if(!empty($value->plaintext) && !strpos($contentDB,$value->plaintext)){
                $contentDB = $contentDB.'<p align="center">'.$value->find('figcaption',0)->plaintext.'</p><br>';
            }
        } else {// 내용 텍스트라면
            if(!empty($value->find('b',0)->plaintext) && !strpos($contentDB,$value->plaintext)){
                $contentDB = $contentDB.'<p align="left"><b>'.$value->plaintext.'</b></p><br>';
                $textcontent = $textcontent." ".$value->plaintext;
            } elseif(!empty($value->plaintext) && !strpos($contentDB,$value->plaintext)){
                $contentDB = $contentDB.'<p align="left">'.$value->plaintext.'</p><br>';
                $textcontent = $textcontent." ".$value->plaintext;
            }         
        }
    }
    $precontentDB = iconv_substr($textcontent,0,200, "utf-8");

    if($contentDB != "" && $precontentDB != "" && $mainimgDB != "") {
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
            WHERE NOT EXISTS (SELECT * FROM reviewList WHERE refurl = '" . $refurlDB . "') LIMIT 1";
            // 쿼리문 실행 및 결과 출력
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "New record created successful";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                break;
            }
    } else {
        echo "data is null!";
    }
    // php 메모리 부하가 올 수 있으므로 다 쓴 html 문서는 메모리에서 삭제시킨다.
    $html->clear();
    unset($html);
}

