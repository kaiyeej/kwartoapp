<?php
include '../core/config.php';

ini_set('date.timezone','UTC');
date_default_timezone_set('UTC');
$today = date('H:i:s');

$ref_num = "REF-".date("njygis",strtotime($today)+28800);
echo $ref_num;