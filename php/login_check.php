<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/console_log.php';

if (isset($_SESSION['user_id'])) {
    Console_log($_SESSION['nickName']);
} else {
    Console_log('세션 값 없음');
}
