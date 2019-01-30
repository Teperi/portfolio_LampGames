<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/simplehtmldom/simple_html_dom.php';

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
$today = date("Ymd");

// 목록에 있는 href 목록을 가져오기
// 1. 우선 CURL 에 있는 내용을 컴퓨터에 저장
$curlfile = get_content('https://news.naver.com/main/list.nhn?mode=LPOD&mid=sec&oid=356&date=' . ($today - 1));
$localfile = fopen($_SERVER['DOCUMENT_ROOT'] . '/savenews/' . ($today - 1) . '_list.html', 'w');
fwrite($localfile, $curlfile);
fclose($localfile);

// 2. localfile 에 있는 데이터를 simple htmle dom parser 로 변환해서 상황 보기
// 완전히 저장 된 후 아래 작업 시작을 위해 sleep 적용
sleep(2);
// html 파일을 simple dom parser 를 사용해서 a 태그 안의 href 만 가져옴
$html = file_get_html($_SERVER['DOCUMENT_ROOT'] . '/savenews/' . ($today - 1) . '_list.html');
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
$folder = $_SERVER["DOCUMENT_ROOT"] . '/savenews/' . ($today - 1);

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

    
    echo trim($html->find('div.news_headline h4', 0)->plaintext);
    echo '<br>';
    echo trim($html->find('div.news_headline div.info span', 0)->plaintext);
    echo '<br>';
    echo $html->find('div.news_headline div.info a.press_link', 0)->href;
    echo '<br>';

    // clean up memory
    $html->clear();
    unset($html);
}

// foreach ($newsUrlList as $value) {
//     $curlfile = get_content('https://news.naver.com/main/list.nhn?mode=LPOD&mid=sec&oid=356&date=' . ($today - 1));
//     $localfile = fopen($_SERVER['DOCUMENT_ROOT'] . '/savenews/' . ($today - 1) . '_list.html', 'w');
//     fwrite($localfile, $curlfile);
//     fclose($localfile);
// }

// $hreflist;
// // 기사 목록 페이지의 내용 전체를 불러온 후, 정규식을 통해 링크 리스트를 만들기
// // oid = 356 : 게임메카의 기사만 가져올 수 있게 함
// // 사유 : 추천 기사 및 다른 사이트로 이동될 수 있으므로 OID 를 고정해서 정확한 목록을 가져오도록 함
// preg_match_all("/https:\/\/news.naver.com\/main\/read.nhn\?[\w|&|=]*(\&oid=356)[\w|&|=]*/is", $gethref, $hreflist);

// // 그냥 news.naver.com 으로 접속하면 curl 에서 에러가 남.
// // 쉬운 크롤링을 막기 위한 도구로 확인됨
// // 따라서 모든 주소를 원본 기사의 주소로 바꿔줌
// // 실제 뉴스 목록을 클릭해보니 news.naver.com 에서 sports.news.naver.com/esports/news 로 바뀌는 것을 확인할 수 있었음

// $i = 0;
// $urllist = array();
// foreach (array_unique($hreflist[0]) as $value) {
//     $urllist[$i] = str_replace("https://news.naver.com/main/read.nhn", "https://sports.news.naver.com/esports/news/read.nhn", $value);
//     $i++;
// }