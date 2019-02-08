<?php

// 
// 이 파일은 더 이상 사용하지 않음
// 과거 기록을 위해 남겨놓기로 함
// 

include $_SERVER["DOCUMENT_ROOT"] . '/php/simplehtmldom/simple_html_dom.php';

function get_content($url)
{
    $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36';
    $curlsession = curl_init();
    curl_setopt($curlsession, CURLOPT_URL, $url);
    curl_setopt($curlsession, CURLOPT_HEADER, false);
    curl_setopt($curlsession, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curlsession, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlsession, CURLOPT_POST, 0);
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

function newstoserver($list)
{
    require $_SERVER["DOCUMENT_ROOT"] . '/php/connectDB.php';
    foreach ($list as $value) {
        $getnews = get_content($value);
        // 타이틀 가져오기
        preg_match_all("/<h4 class=\"title\">(.+)<\/h4\>/", $getnews, $title_raw);
        $title = str_replace("'", "\'", $title_raw[1][0]);
        // 날짜 가져오기
        preg_match_all("/'([0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2})'/", $getnews, $date);
        // 메인 이미지 주소 가져오기
        preg_match_all("/<span class=\"end_photo_org\"><img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/", $getnews, $mainimg);
        // ref 만들기 oid=356 : 게임메카
        $ref = '게임메카';
        // 원문기사 주소 가져오기
        preg_match_all("/<a target=\"_blank\" href=\"(.+)\" class=\"press_link\">/", $getnews, $refurl);
        // 기사 내용 가져오기
        preg_match_all("/(<div style=\".+\">.*<\/div>)/", $getnews, $content_raw);
        $content = str_replace("'", "\'", $content_raw[1][0]);
        // 기사 미리보기 내용 가져오기
        preg_match_all("/<br><\/div><div style=\"text-align: justify;\" align=\"justify\">(.+)<\/div><div style=\"text-align: justify;\" align=\"justify\">/", $getnews, $precontent_raw);
        $precontent_raw[1][0] = str_replace("'", "\'", $precontent_raw[1][0]);
        $precontent = iconv_substr($precontent_raw[1][0], 0, 60, "utf-8");
        $precontent = str_replace("<div style=\"text-align: justify;\" align=\"justify\">", " ", $precontent);
        $precontent = str_replace("<\/div>", " ", $precontent);
        $precontent = str_replace("<br>", " ", $precontent);
        if (strlen($content) <= 0 | strlen($precontent) <= 0) {
            echo "내용 없어서 패스<br>";
            sleep(1);
        } else {
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
                '" . $title . "',
                '" . $mainimg[1][0] . "',
                '" . $date[1][0] . "',
                '" . $ref . "',
                '" . $refurl[1][0] . "',
                '" . $precontent . "',
                '" . $content . "'
            ) AS tmp
            WHERE NOT EXISTS (SELECT * FROM reviewList WHERE title = '" . $title . "') LIMIT 1";
            // 쿼리문 실행 및 결과 출력
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "New record created successfully<br>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                break;
            }
        }

    }
}

$gethref = get_content('https://news.naver.com/main/list.nhn?mode=LPOD&mid=sec&oid=356&date=20190107');
$hreflist;
preg_match_all("/https:\/\/news.naver.com\/main\/read.nhn\?[\w|&|=]*(\&oid=356)[\w|&|=]*/is", $gethref, $hreflist);

$i = 0;
$urllist = array();
foreach (array_unique($hreflist[0]) as $value) {
    $urllist[$i] = str_replace("https://news.naver.com/main/read.nhn", "https://sports.news.naver.com/esports/news/read.nhn", $value);
    $i++;
}

newstoserver($urllist);
