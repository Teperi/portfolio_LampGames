<?php
$date = new DateTime("now");
print $date->format("c");
$date->setTimezone(new DateTimeZone("Asia/Seoul"));
print $date->format("c");
$us_date = new DateTime("now", new DateTimeZone("US/Eastern"));
print $us_date->format("c");
?>