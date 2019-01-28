<?php
include_once '../../simple_html_dom.php';

function scraping_digg()
{
    // create HTML DOM
    $html = file_get_html('http://digg.com/');
    $ret;
    // get news block
    foreach ($html->find('div.digg-story__content') as $article) {
        // get title
        $item['title'] = trim($article->find('h2', 0)->plaintext);
        // // get details
        // $item['details'] = trim($article->find('p', 0)->plaintext);
        // // get intro
        // $item['diggs'] = trim($article->find('li a strong', 0)->plaintext);

        $ret[] = $item;
    }

    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

// -----------------------------------------------------------------------------
// test it!

// "http://digg.com" will check user_agent header...
ini_set('user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:64.0) Gecko/20100101 Firefox/64.0');

$rett = scraping_digg();

foreach ($rett as $v) {
    echo $v['title'] . '<br>';
    // echo '<ul>';
    // echo '<li>' . $v['details'] . '</li>';
    // echo '<li>Diggs: ' . $v['diggs'] . '</li>';
    // echo '</ul>';
}
