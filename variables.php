<?php 
$bad_sql = array("union","select","from","where","insert"," or "," and ","/\*","'",);
$bad_include = array("http://","../",".php",".phtml",".php3",".php4","./",".php5",);
$bad_xss = array("<script","document.cookie","javascript:",);
$allow = array("filelink","txt");
$allow_custom = array("filelink"=>array("http://"),"url"=>array("http://"),"site"=>array("http://"),"txt"=>array("http://"),"homepage"=>array("http://"));?>
