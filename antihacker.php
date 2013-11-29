<?php
/*
////////////////////////////////////////////////////////////
|        DLsecure module by NuR, Green_Bear and Winux      |
|                    http://damagelab.org                  |
|               http://dlsecure.damagelab.org/             |
|                                                          |
|                   (c) 2007 DaMaGeLaB.OrG                 |
|            Respect: NuR, Winux, HAWK, Green_Bear etc.    |
|                      DLsecure 0.0.1.4                    |
\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
*/
error_reporting(0);
define('IN_AH', true);
define('CODE_SQL', 'sql');
define('CODE_XSS', 'xss');
define('CODE_INCLUDE', 'include');
define('TIMENOW', time());
define('BROWSER', clear($_SERVER['HTTP_USER_AGENT']));
define('IP', $_SERVER['REMOTE_ADDR']);
define('URI', clear($_SERVER['REQUEST_URI']));
require ('antihacker_cnf.php');
$fl=file(MODULE_DIR."/ip.txt");
if ($_COOKIE["cook"]=='sorry')
{
  include("baned.php");
  die;
} else
for ($i=0;$i<sizeof($fl);$i++){
  $fl[$i]=str_replace("\n",'',$fl[$i]);
  $fl[$i]=str_replace("\r",'',$fl[$i]);
  if (getenv("REMOTE_ADDR")==$fl[$i]) { $f=1;
  setcookie("cook","sorry",time()+31536000); //бан на год=))) обходиться тупо, но это чтобы лишний раз не читать файл
  include("baned.php");
    die;
  }
}
if (DEBUG_MODE == 'no')
    define('PAGE', 'stop.php');
if (DEBUG_MODE == 'yes')
    define('PAGE', 'debug.php');
$conn_id = mysql_connect($db['sql_host'], $db['sql_user'], $db['sql_pass']) or
    die(mysql_error());
mysql_select_db($db['sql_database']) or die(mysql_error());
// вставляем конфиги переменных
include ('variables.php');
//
//ddos
//
/***************************************************
* Anti GET DDOS module
* Coded by paraZite
* Last updated on 25.05.2006
****************************************************/
  /* Возможные значения DDOS_LEVEL 0-5:
  | 0. проверка отключена
  | 1. проверка по одному ключу посредством установки cookie
  | 2. проверка по двум ключам посредством html перенаправления c передачей
  |    первого ключа в переменной PHPSESSID и последующей установки второго
  |    ключа в cookie
  | 3. проверка по одному ключу разбитому на 2 части посредством отправки 
  |    запроса на авторизацию WWW-Authenticate
  | 4. полное отключение сайта
  */
if (DDOS_LEVEL!='0')
{
    define('KEY_1', strrev(sha1('dlsecure'.date('d.m.Y'))));
switch(DDOS_LEVEL){
  case 1:
  if(empty($_COOKIE['key'])){
    setcookie('key', KEY_1, time()+2592000);
    header('Location: '.clear($_SERVER['PHP_SELF']));
    die;
  }else{
    if($_COOKIE['key'] !== KEY_1){
    setcookie('key', '');
    header('Location: '.clear($_SERVER['PHP_SELF']));
    die;
    }
  }
  break;
  case 2:
  define('KEY_2', sha1(KEY_1));
  if(empty($_COOKIE['key'])){
    if(empty($_GET['PHPSESSID'])){
    die('<meta http-equiv="refresh" content="0;URL='.clear($_SERVER['PHP_SELF']).'?PHPSESSID='.KEY_1.'" />');
    }elseif($_GET['PHPSESSID'] == KEY_1){
    setcookie('key', KEY_2, time()+2592000);
    header('Location: '.clear($_SERVER['PHP_SELF']));
    die;
    }else{
    die;
    }
  }elseif($_COOKIE['key'] !== KEY_2){
    setcookie('key', '');
    header('Location: '.clear($_SERVER['PHP_SELF']));
    die;
  }
  break;
  case 3:
  if(!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER']!== $ddos['user'] || $_SERVER['PHP_AUTH_PW'] !== $ddos['pass']){
    header('WWW-Authenticate: Basic realm="Введите пароль:  '.$ddos['pass'].'  логин '.$ddos['user'].'"');
    header('HTTP/1.0 401 Unauthorized');
    die;
  }
  break;
  case 4:
  die('Сайт по техническим причинам приостановил свою работу');
  break;
  default:
 // ну это типа защита от кривых рук в блокноте=)
  break;
}
}
//
//end ddos
//
//
//online
//небольшой фикс 28.03.2007 by NuR
$sql = "SELECT * FROM " . TBL_ONLINE . " where ip_addr='" . IP . "'";
$result = mysql_query($sql) or die(mysql_error());
if (!mysql_num_rows($result))
{
    $sql = "INSERT INTO " . TBL_ONLINE . " (id, ip_addr, browser, uri, dateline)
			VALUES ('', '" . IP . "', '" . mysql_real_escape_string(BROWSER) . "', '" .
        mysql_real_escape_string(URI) . "', '" . TIMENOW . "') ";
    mysql_query($sql) or print (mysql_error());
}
else
{
    $sql = "UPDATE  " . TBL_ONLINE . "
	set browser='" . mysql_real_escape_string(BROWSER) . "',
	uri='" . mysql_real_escape_string(URI) . "',
	dateline='" . TIMENOW . "'
	WHERE ip_addr='" . IP . "'";
    mysql_query($sql) or print (mysql_error());
}
//
//end online
//
//
//logs
//
if (REQUEST_LOGING=="yes")
{
$str = $_SERVER['REMOTE_ADDR'] . "|||" . TIMENOW . "|||" . htmlspecialchars($_SERVER['REQUEST_URI']);
$file = ROOT_DIR . '/' . MODULE_DIR . '/' . DATADIR . '/' . IP;
$f = fopen($file, "a");
fwrite($f, $str . "\n");
fclose($f);
}
//
//end logs
//
if ($_REQUEST)
{
    foreach ($_REQUEST as $k => $v)
    {
        @check(urldecode($v), $k, CODE_XSS);
        @check(urldecode($v), $k, CODE_SQL);
        @check(urldecode($v), $k, CODE_INCLUDE);
    }
}
function check($str, $key, $type)
{
    global $allow, $allow_custom, $bad_include, $bad_sql, $bad_xss;
    if ($type == 'sql')
        $bad_array = $bad_sql;
    if ($type == 'xss')
        $bad_array = $bad_xss;
    if ($type == 'include')
        $bad_array = $bad_include;
    $str = str_replace("\n", " ", $str);
    $str = explode(" ", trim($str));
    foreach ($str as $s)
    {
        $i = 0;
        $s = strtolower($s);
        if (@is_array($allow_custom[$key]) and count($allow_custom[$key]))
        {
            for ($i = 0; $i < count($bad_array); $i++)
            {
                $bad = $bad_array[$i];
                if (eregi($bad, $s))
                    $_allow[$key][$i] = false;
                else
                    $_allow[$key][$i] = true;
                foreach ($allow_custom[$key] as $al)
                {
                    if (eregi($al, $s))
                    {
                        $_allow[$key][$i] = true;
                        break;
                    }
                }
                #echo $_allow[$key][$i] ? $_allow[$key][$i] : $key;
                if (!$_allow[$key][$i] and !in_array($key, $allow) )
                {
                    @sql_query($str[$i], $key, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'],
                        $_SERVER['HTTP_REFERER'], $type);
                }
            }
            unset($_allow);
        }
        else
        {
            for ($i = 0; $i < count($bad_array); $i++)
            {
                $bad[$i] = $bad_array[$i];
                if (eregi($bad_array[$i], $s))
                    $_allow[$key][$i] = false;
                else
                    $_allow[$key][$i] = true;
                if (!$_allow[$key][$i] and !in_array($key, $allow))
                {
                    @sql_query($str[$i], $key, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'],
                        $_SERVER['HTTP_REFERER'], $type); //зорки глаз рута=)
                }
            }
            unset($_allow);
        }
        $i++;
    }
}
function sql_query($string, $var, $ip, $agent, $ref, $type)
{
    global $conn_id, $stop;
     //thx to ZXroot
    if (!$stop )
    {
        @$string = "String:" . mysql_real_escape_string($_SERVER['QUERY_STRING']) . ", \nBad: $var=" .
            mysql_real_escape_string($string);
        $agent = mysql_real_escape_string($agent);
        $ref = mysql_real_escape_string($ref);
        if ($type == "sql")
            $reason = "Попытка проведения SQL-инъекции \n\n";
        if ($type == "include")
            $reason = "Попытка инклюдинга \n\n";
        if ($type == "xss")
            $reason = "Попытка проведения XSS атаки \n\n";
        $reason .= htmlspecialchars(stripcslashes($string));
		if(HACK_LOGING=="yes")
		{
        mysql_query("INSERT INTO " . TBL_LOG .
            "(id, dateline, query_string, ip, browser, http_referer, type)
					VALUES('',
					'" . time() . "',
					'$string',
					'$ip',
					'$agent',
					'$ref',
					'$type');");
		}
        include (PAGE);
        die();
    }
}
function clear($str)
{
    $str = urldecode($str);
    $str = htmlspecialchars($str);
    return $str;
}
?>