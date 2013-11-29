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
//error_reporting(0);
//теперь авторизуемся через сессии=) 28.03.2007 by NuR
  unset($logged_user);
  unset($logged_user);
  session_start();
  session_register($logged_user);
  if(!isset($logged_user)){
    header("Location: index.php");
    exit;
  }
  
  
  function clear($str)
{
    $str = urldecode($str);
    $str = htmlspecialchars($str);
    return $str;
}
define('IN_AH', true);
require('antihacker_cnf.php');
$script = clear(@$_SERVER['SCRIPT_NAME']);
error_reporting(0);
$posix = (stristr(php_uname(),'win')) ? 0 : 1; //проверка на чём крутиться сервак
$conn_id = mysql_connect($db['sql_host'], $db['sql_user'], $db['sql_pass']) or die(mysql_error());
mysql_select_db($db['sql_database']) or die(mysql_error());
echo <<<html
<link rel="stylesheet" content="text/css" href="style.css">
<title>DLSecure Module [DaMaGeLaB.OrG] -> Панель администратора</title>
<BODY text="ffffff" link="ffffff" alink="ffffff" vlink="ffffff">
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 ALIGN=CENTER>
<TR>
<TD HEIGHT=100% ALIGN=center VALIGN=top>
<TABLE WIDTH=95% BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD VALIGN=TOP STYLE="border: 1px solid #056E04;">
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD HEIGHT=15 class="titl" colspan="8">
<A HREF="http://damagelab.org" class="atitl">DLSecure Module [DaMaGeLaB.OrG] -> Панель администратора</A>
</TD>
</TR>
<TR>
<TD HEIGHT=15 class="menu">
<A HREF="admin.php" class="atitl">• Попытки взлома</A>  <A HREF="$script?act=whois" class="atitl">• WhoIs</A>
<A HREF="$script?act=online" class="atitl">• OnLine</A>    <A HREF="$script?act=showlogs" class="atitl">• Логи</A>(<a href="$script?act=showlogs&do=clear" style="color:red">x</a>)
  <A HREF="$script?act=av" class="atitl">• Антивирус</A>
  <A HREF="$script?act=slog" class="atitl">• Логи доступа по FTP и SSH</A>
   <A HREF="$script?act=options" class="atitl">• Опции</A>
   <A HREF="$script?act=apache" class="atitl">• Логи апача</A>
   <A HREF="$script?act=help" class="atitl">• Помощь</A>
</TD>
</TR>
<TR>
<td class="styl" colspan="8" bgcolor=#056E04>
html;
$a_i = 0;
$act = @$_GET['act'];
//////////
///banlist wiever & unbaner
//////
if($act=='banlist')
{


$list=file("ip.txt");
echo("<form action='$script?act=unban&unban=$ip' method='post'>
<table border='1' bordercolordark='white' bordercolorlight='black' align='center'>");
foreach($list as $ip)
  {
      $ip=clear($ip); //параноя, но всё же=)
echo("
<tr>

    <td>
     <A HREF='$script?act=unban&unbip=$ip' class='atitl'>$ip</A>
    </td>
</tr>
"); 
   }

   echo("</table>");
}
//thx to ZXroot
if($act=='unban')
{
  $banz = file('ip.txt');
  foreach($banz as $ip)
  {
    //$ip = str_replace("\n","",$ip);
    $ip=trim($ip);
    if($ip == $unbip)
    {
      $noip = 1;
    } else {
      $s .= $ip."\n";
    }
  }
  $f = fopen('ip.txt', "w");
  fwrite($f, $s);
  fclose($f);
//echo "<script>location.href= location.href;</script>"; бля хули не работаетъ
//echo "<script>location.href= location.href;</script>";
//header("Location: admin.php");
            //die();
}



//////////////
/////end unban
///////////////
//
//logs
//
if (!$act or $act == 'log')
{
echo <<<html
<A HREF="$script?act=banlist" class="atitl">Банлист</A>
<table cellspacing="0" width="98%" align="center">
    <tr>
        <td class="dot"><b>Дата</b></td>
        <td class="dot"><b>Попытка атаки</b></td>
        <td class="dot"><b>Комментарий</b></td>
        <td class="dot"><b>IP хакера</b></td>
        <td class="dot"><b>•</b></td>
        <td class="dot"><b>Бан</b></td>
    </tr>
<form action="$script" method="post">
html;
    switch (@$_POST['do'])
    {
        case 'Delete selected':
            if ($_POST['id'] and count($_POST['id']))
            {
                foreach ($_POST['id'] as $i)
                    $str .= "'$i', ";
            }
            $str = substr($str, 0, -2);
            mysql_query("DELETE FROM " . TBL_LOG . " where id IN($str);") or die(
                mysql_error());
            echo "<script>location.href= location.href;</script>";
            die();
            break;
        case 'Clear table':
            mysql_query("TRUNCATE TABLE " . TBL_LOG) or die(mysql_error());
            echo "<script>location.href= location.href;</script>";
            die();
            break;
          //банилка по ип=) хз но комунить может пригодиться
		  //28.03.2007 by NuR t s
        case 'ban':
             if ($_POST['ip'])
               {
                foreach ($_POST['ip'] as $i)
                {
                $toban.=$i."\n";	
				}
		$f = fopen('ip.txt', "a");
        fwrite($f, $toban);
        fclose($f);
        echo "Хацкеры успешно забанены!=)";
       // echo "<script>location.href= location.href;</script>";
            }
          // die();
		break;    
        default:
            @$_GET['page'] ? $page = intval($_GET['page']):$page = 0;
            $sql = "SELECT * FROM " . TBL_LOG . " ORDER BY dateline DESC LIMIT $page, 30";
            $result = mysql_query($sql, $conn_id) or die(mysql_error());
            $count = mysql_num_rows(mysql_query("SELECT * FROM " . TBL_LOG));
            while ($data = mysql_fetch_array($result, MYSQL_ASSOC))
            {
                if ($data['type'] == 'sql')
                    $reason = "Попытка проведения SQL-инъекции";
                if ($data['type'] == 'xss')
                    $reason = "Попытка проведения XSS атаки";
                if ($data['type'] == 'include')
                    $reason = "Попытка инлудинга";
                $data['query_string'] = htmlspecialchars($data['query_string']);
                $date = date('d.m.Y H.i', $data['dateline']);
                echo <<< EOF
			<tr>
              <td class="dot">{$date}</td>
              <td class="dot"><center><pre id="wrap">{$data['query_string']}</pre></center></td>
      		  <td class="dot">{$reason}</td>
    		  <td class="dot"><a href="?act=whois&IP={$data['ip']}">{$data['ip']}</a></td>
  		      <td class="dot"><input type=checkbox value='{$data['id']}' name='id[]'></td>
  		      <td class="dot"><input type=checkbox value='{$data['ip']}' name='ip[]'></td>
		    </tr>
EOF;
            }
            echo <<< EOF
<tr><td colspan=4>
    <br />
    <input type=submit value="Delete selected" name="do">
    <input type=submit value="Clear table" name="do">
    <input type=submit value="ban" name="do" title="банить нах">
	</td></tr>
</table>
EOF;
            echo get_pages($count);
            break;
    }
}
//
//end logs
//
//
//whois
//
if ($act == 'whois')
{
    if (!$_GET['IP'])
    {
        echo <<< HTML
		<form action='$script' method="GET">
		<input type='hidden' name='act' value='whois' />
		<input type='text' value='{$_GET['IP']}' name='IP' />
		<input type='submit' value='Whois' />
		</form>
HTML;
    }
    else
    {
        $sock = fsockopen("whois.ripe.net", 43, $errno, $errstr);
        if (!$sock)
            echo ("$errno($errstr)");
        else
        {
            fputs($sock, $_GET['IP'] . "\r\n");
            echo "<div align=left style='font-weight: normal'>";
            while (!feof($sock))
            {
                echo (str_replace(":", ":      ", fgets($sock, 128)) . "<br />");
            }
            echo "</div>";
        }
        fclose($sock);
    }
}
//логи доступа с ссш и фтп протоколу, надо дорабатывать 21.03.07 by NuR
//доработал 22.03.07 by NuR
if ($act == 'slog')
{
	if ($posix==0)
	{
		echo('Данная функция поддерживаеться только на unix серверах');
		exit;
	} 
$uid = getmyuid();
$name = posix_getpwuid($uid);
$log = 'last | grep ' . $name['name'];
exec($log, $tr); //сигнатура палиться антивирусом, но без этого никак
echo ('<table border="1" bordercolordark="white" bordercolorlight="black" align="center">');
echo '
	<tr>
	<td>логин</td>
	<td>протокол</td>
	<td>ип адрес</td>
	<td>дата</td>
	<td>начало сессии</td>
	<td>конец сессии</td>
	<td>время соединения</td>
</tr>';
foreach ($tr as $line)
{
	$st = preg_split('/[\s]+/', $line);
    if ($st[7]=='still')
    {
        //если самая верхняя запись, и типа
        //fora         ftp      127.0.0.1      Thu Mar 22 00:51   still logged in
        //индэксы будут немного другими
        // писдец я заебался эту красоту наводить... ебаная табличка=) зато красиво =)
        echo "
<tr>
	<td>$st[0]</td>
	<td>$st[1]</td>
	<td>$st[2]</td>
	<td>$st[3] $st[4] $st[5]</td>
	<td>$st[6]</td>
	<td>----</td>
	<td>$st[7] $st[8] $st[9]</td>
</tr>
";
    }
if ($st[7]!='still') //если просто лог, а не то что он в онлайне
   {
    echo "
<tr>
	<td>$st[0]</td>
	<td>$st[1]</td>
	<td>$st[2]</td>
	<td>$st[3] $st[4] $st[5]</td>
	<td>$st[6]</td>
	<td>$st[8]</td>
	<td>$st[9]</td>
</tr>
";
}
}
echo ('</table>');
}
//
//end slog
//
//
//online
//небольшой фикс онлайна, имхо просто опечатка рухака 28.03.2007 by NuR
if ($act == 'online')
{
    $_GET['page'] ? $page = intval($_GET['page']):$page = 0;
    $sql = "DELETE FROM " . TBL_ONLINE . " where dateline < '" . (TIMENOW + 300) . "'";
	mysql_query($sql) or die(mysql_error()); //теперь онлайн будет выводиться коректно
    $sql = "SELECT * FROM " . TBL_ONLINE . " order by dateline desc LIMIT $page, 30";
    $count = mysql_num_rows(mysql_query("SELECT * FROM " . TBL_ONLINE));
    $result = mysql_query($sql, $conn_id) or die(mysql_error());
    echo <<< EOF
	<div align='center'>
	<table border='0' width='90%'>
	<tr>
		<td width='10' class="dot"><b>#</b></td>
		<td class="dot"><b>Страница</b></td>
		<td width='150' class="dot"><b>Активность</b></td>
		<td width='100' class="dot"><b>IP</b></td>
		<td width='200' class="dot"><b>Браузер</b></td>
	</tr>
EOF;
    $i = 0;
    while ($data = mysql_fetch_array($result, MYSQL_ASSOC))
    {
        $time = date('H.i.s', $data['dateline']);
        echo <<< EOF
		<tr>
		<td width='10' class="dot"><i>{$i}</i></td>
		<td class="dot"><div id=wrap2><a href="{$data['uri']}">{$data['uri']}</a></div></td>
		<td width='150' class="dot">{$time}</td>
		<td width='100' class="dot"><a href="?act=whois&IP={$data['ip_addr']}">{$data['ip_addr']}</a></td>
		<td width='200' class="dot">{$data['browser']}</td>
	</tr>
EOF;
        $i++;
    }
    echo "</table></div>";
}
//
//end online
//
//
//logs
//
if ($act == 'showlogs')
{
    switch ($_GET['do'])
    {
        case 'clear':
            $dir = opendir(DATADIR);
            while (false !== ($file = readdir($dir)))
                if ($file != "." and $file != ".." and $file!=".htaccess")
                    @unlink(DATADIR . '/' . $file);
            echo "Лог очищен";
            break;
        default:
            if (!$_GET['IP'])
            {
                echo "<div align='left' style='font-weight: normal'>";
                $dir = opendir(DATADIR);
                while (false !== ($file = readdir($dir)))
                    if ($file != "." and $file != ".." and $file!=".htaccess")
                        $ips[] = $file;
                $count = count($ips);
                if ($count > 30)
                {
                    $_GET['page'] ? $page = intval($_GET['page']):$page = 0;
                    $page ? $array_start = $page:$array_start = 0;
                    for ($i = $array_start; $i < $array_start + 30; $i++)
                        echo "<a href=\"?act=showlogs&IP=$ips[$i]\">$ips[$i]</a><br /> \n";
                    echo get_pages($count);
                }
                else
                {
                    foreach ($ips as $ip)
                        echo "<a href=\"?act=showlogs&IP=$ip\">$ip</a><br /> \n";
                }
                echo "</div>";
            }
            else
            {
                if (file_exists(DATADIR.'/'.$_GET['IP']) and preg_match('/^\d{1,3}.\\d{1,3}.\\d{1,3}.\\d{1,3}$/',$_GET['IP']))
                {
                    echo "<table border='0' width='100%'><tr>
			<td width='100'>IP</td>
			<td width='100'>Время</td>
			<td >Адрес</td>
			</tr>";
                    $data = file(DATADIR . '/' . $_GET['IP']);
                    foreach ($data as $v)
                    {
                        $v = explode("|||", $v);
                        echo "<tr>
			<td width='100'><a href=\"?act=whois&IP=$v[0]\">$v[0]</a></td>
			<td width='100'>" . date('d.m.Y - H.i.s', $v[1]) . "</td>
			<td >$v[2]</td>
			</tr>";
                    }
                    echo "</table>";
                }
                else
                    echo "Не могу открыть лог";
            }
            break;
    }
}

///////////////////////////////////////////////////////////////////////////////////////
//пересканирование файлов и занесение новых данных о дате изменения и размерах by NuR
//upd
///////////////////////////////////////////////////////////////////////////////////////
if ($act == 'upd')
{
$sql = "DELETE FROM " . FILEBASE;
mysql_query($sql, $conn_id) or die(mysql_error());
$antivirus = new antivirus;
    $antivirus->scan(ROOT_DIR);	
echo("Пересканирование завершено. Даты и размеры занесены в БД");	
}
/////////////////////////////
///apache logs parser by NuR 28.04.2007
///доработал, сделал парсилку на подозрительные запросы, хочу пива=) всех с праздником!=)01.04.2007 
///////////////////////////////
//2beta testers: надо полностиь, вдоль поперёк протестить эту функцию. NuR

if ($act == 'apache')
{
 switch ($_GET['parm'])
    {
        case '404':
            {
     if(!file_exists(APACH_LOGS)) die("Логи апача не обнаружены");
  echo '
  <table border="1" bordercolordark="white" bordercolorlight="black" align="center"><br>
  <tr>
     <td align="center">IP</td>     
     <td align="center">Date</td>     
     <td align="center">Method</td> 
     <td align="center">HTTP ver</td>
     <td align="center">Page</td>     
  </tr>
  ';
  $log=APACH_LOGS;
  $fl=file($log);
   $den=date("Ymd",time()-TLOG*86400); // для вывода инфы о конкретном дне=)
  // echo($den."<br>");
  for($i=0;$i<count($fl);$i++)
  {
$str=explode(" ", $fl[$i]);
$dt=substr($str[3],1)." ".substr($str[4],0,5); //у меня чуть крыша не поехала пока я делал перевод даты
$dt=substr($dt,0,2)." ".substr($dt,3,3)." ".substr($dt,7,4)." ".substr($dt,12,8)." ".substr($dt,-5,5);
$data=date("Ymd",strtotime ($dt));
//$dt=date("Y-m-d H:i:s",strtotime ($dt));
$timelog=TLOG*86400;
$den=time() - $timelog; // для вывода инфы о конкретном дне=)
$trs=date("Ymd",$den);
//echo("------");
//echo($trs."<br>");
//echo($trs."<br>".$data."<br>");
if($data==$trs)
{
$den=time()-TLOG*86400; // для вывода инфы о конкретном дне=)
$trs=date("Ymd",$den);
      if(preg_match("/(.*) - - \[(.*)\+.*\] \"(.*) (.*) (.*)\" (.*) /i", $fl[$i], $arr))
        {
$dt=substr($dt,0,2)." ".substr($dt,3,3)." ".substr($dt,7,4)." ".substr($dt,12,8)." ".substr($dt,-5,5);
$data=date("Ymd",strtotime ($dt));
   if($arr[6]=='404')
        {
            $y=0;
          foreach ($arr as $er)
              {
                  $arr[$y]=clear($er);
                  $y++;
                }
          echo ("<tr>
          <td>$arr[1]</td>     
          <td>$arr[2]</td>     
          <td>$arr[3]</td>
          <td>$arr[5]</td>  
          <td>$arr[4]</td>     
          </tr>");
          }
        }
        }//}
//  }
}
}
echo("</table>"); 

break;
case 'hz':
//пока переделывать геморно =(
if(!file_exists(APACH_LOGS)) die("Файл с логами апача не найден");
$log=APACH_LOGS;
$fl=file($log);
echo '
<table border="1" bordercolordark="white" bordercolorlight="black" align="center"><br>
<tr>
	<td>IP</td>	
	<td>Date</td>	
	<td>Method</td> 
	<td>HTTP ver</td>
	<td>eror</td>
	<td>Page</td>	
</tr>
';
for($i=0;$i<count($fl);$i++)
{
$str=explode(" ", $fl[$i]);
$host=$str[0];
$dt=substr($str[3],1)." ".substr($str[4],0,5); //у меня чуть крыша не поехала пока я делал перевод даты
$dt=substr($dt,0,2)." ".substr($dt,3,3)." ".substr($dt,7,4)." ".substr($dt,12,8)." ".substr($dt,-5,5);
$data=date("Ymd",strtotime ($dt));
//$dt=date("Y-m-d H:i:s",strtotime ($dt));
$timelog=TLOG*86400;
$den=time() - $timelog; // для вывода инфы о конкретном дне=)
$trs=date("Ymd",$den);
//echo("------");
//echo($trs."<br>");
//echo($trs."<br>".$data."<br>");
if($data==$trs)
{
$method=substr($str[5],1);
$pageon=$str[6];
$protocol=substr($str[7],0,strpos($str[7],'"'));
$code=$str[8];
//тут делаем что надо
$hackcmd = array('chr(', 'r57shell', 'remview', 'config=', 'OUTFILE%20',  'uname%20', 'netstat%20', 'rpm%20', 'passwd', 'del%20', 'deltree%20', 'format%20', 'start%20', 'wget', '|', 'select%20', 'SELECT', 'cmd=', 'rush=', 'union', 'javascript:', 'UNION', 'echr(', 'esystem(', 'cp%20', 'mdir%20', 'mcd%20', 'mrd%20', 'rm%20', 'mv%20', 'rmdir%20', 'chmod(', 'chmod%20', 'chown%20', 'chgrp%20', 'locate%20', 'diff%20', 'kill%20', 'kill(', 'killall', 'cmd', 'command', 'fetch', 'whereis', 'grep%20', 'ls -', 'lynx', 'su%20root', 'test', 'etc/passwd',  "'", '%60', '%00', '%F20', 'echo', 'write(', 'killall', 'passwd%20', 'telnet%20', 'vi(', 'vi%20', 'INSERT%20INTO', 'SELECT%20', 'javascript', 'fopen', 'fwrite', '$_REQUEST', '$_GET'); //подозрительные запросы типа=)
$hackparam=$str[6]; //парсим код от html тегов (для дальнейшего сохраниния)
//print_r($hackparam);
//print_r($haclmf);
foreach($hackcmd as $cmd)
{
//$checkcmd = str_replace($cmd, 'X', $hackparam); //тупо, но ничё умнее я придумать не мог=( пива нету=()
if (stristr($hackparam,$cmd) )
{
$pageon= clear($pageon);
$host= clear($host);
$dt= clear($dt);
$method= clear($method);
$protocol= clear($protocol);
$code= clear($code);
echo ("<tr>
<td>$host</td>	
<td>$dt</td>	
<td>$method</td>
<td>$protocol</td>	
<td>$code</td>
<td>$pageon</td>	
</tr>");
}
}
}}
break;
default:
echo('<a href="?act=apache&parm=404">404</a>');
echo("<br>");
echo('<a href="?act=apache&parm=hz">Подозрительные запросы</a>');
break;
}
}
/////////////////////////////
///end apache logs parser
///////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
//end upd
///////////////////////////////////////////////////////////////////////////////////
if ($act == 'av')
{
    $antivirus = new antivirus;
    $antivirus->scan(ROOT_DIR);
echo('<A HREF="'.$script.'?act=upd" class="atitl">Обновить информацию в БД</A>');
 echo('<table border="1" bordercolordark="white" bordercolorlight="black" align="center">');
echo('<tr><td>Фаил</td><td>Уровень угрозы</td><td>Сигнатура</td><td>Изменён</td><td>Размер</td><td>UID хазяина</td></tr>');
//    echo "<div><b>Подозрительные файлы:</b></div><div align='left'>";
    //  $antivirus->show_files();
   $zapros = "SELECT filee,date,size,level,risk,signature,uid FROM " . FILEBASE . " WHERE level>10 OR risk='high' ORDER BY level DESC";
    $result = mysql_query($zapros);
    while ($row = mysql_fetch_array($result))
    {
        if ($row['risk'] == 'high')
            echo("<tr><td>".$row['filee']."</td><td>".$row['level']."</td><td>".$row['signature']."</td><td>".$row['date']."</td><td>".my_size($row['size'])."</td><td>".$row['uid']."</td></tr>");
			else
			echo("<tr><td>".$row['filee']."</td><td>".$row['level']."</td><td>".$row['signature']."</td><td>Нет</td><td>".my_size($row['size'])."</td><td>".$row['uid']."</td></tr>");
    }
    echo ('</table>');
}
//
//help
//
if ($act == 'help')
{
    echo <<< EOF
	<table align='left' border='0'><tr><td>
	<b>Мануал по установке и настройке блокировки атак</b><br>
					<i>Статья наглядно демонстрирует настройку модуля с разжевыванием материала для низкокомпетентных людей. Также в статье описан принцип действия дебаг режима и настройки переменных и исключений.</i><br>
					<a href="http://damagelab.org/index.php?showtopic=17294" target="_top">Читать полностью....</a>
	</td></tr></table>
EOF;
}
//
//end help
//
if ($act == 'phpinfo')
{
phpinfo();
}
//
//options
//
if ($act == 'options')
{$dt=array();
$df=array();
$i=0;
$g=0;
$hly=array();
$hln=array();
	 //thx to ZXroot
	switch (DDOS_LEVEL)
       {
       case '0':
        $ddos0="selected";
        break;
       case "1":
        $ddos1="selected";
       break;
        case "2":
        $ddos2="selected";
       break;
        case "3":
        $ddos3="selected";
       break;
        case "4":
        $ddos4="selected";
        break;
       }
	switch (DEBUG_MODE)
       {
       case "yes":
        $i="selected";
        break;
       case "no":
        $g="selected";
        break;
       }
    switch (HACK_LOGING)
       {
       case "yes":
        $hly="selected";
        break;
       case "no":
        $hln="selected";
        break;
       }
       switch (REQUEST_LOGING)
       {
       case "yes":
        $rly="selected";
        break;
       case "no":
        $rln="selected";
        break;
       }
    if (!$_POST['save'])
    {
        $SBASE = SBASE;
        $ROOTDIR = ROOT_DIR;
        $DATADIR = DATADIR;
        $MODULEDIR = MODULE_DIR;
        $FILEBASE = FILEBASE;
        $log = TBL_LOG;
        $online = TBL_ONLINE;
        $debug = DEBUG_MODE;
        $icqq = ICQ;
        $msize=MIN_SIZE;
        $lchange=LAST_CHANGE;
        $alog=APACH_LOGS;
        $tlog=TLOG;
        echo <<< EOF
		<form action="$script?act=options" method="post">
<table border="1" align="center">
<tr>
<td colspan="2"><p align="center">Администратор</p></td>
<td colspan="2"><p align="center">Анти-ддос</p></td>
</tr>
<tr>
<td>Логин:</td>
<td><input type="text" value="{$username}" name="login" /></td>
<td>Режим:</td>
<td><select name="ddoslvl">
<option value="0" $ddos0>Нет</option>
<option value="1" $ddos1>1</option>
<option value="2" $ddos2>2</option>
<option value="3" $ddos3>3</option>
<option value="4" $ddos4>Приостановить работу</option>
</select></td></tr>
<td>Пароль:</td>
<td><input type="password"  name="pass" /></td>
<td>Логин:</td>
<td><input type="text" name="ddos_name" value="{$ddos['user']}" /></td>
</tr>
<tr>
<td>Ася админа:</td>
<td><input type="text" value="{$icqq}" name="icqq" /></td>
<td>Пароль:</td>
<td><input type="text" name="ddos_pass" value="{$ddos['pass']}" /></td>
</tr>
<tr>
<td colspan="2"><p align="center">Система скрипта</p></td>
<td colspan="2"><p align="center">Общие настройки</p></td>
</tr>
<tr>
<td>База сигнатур:</td>
<td><input type="text" name="sbase" value="{$SBASE}" /></td>
<td>Debug mod:</td>
<td><select name="debug"> 
<option value="yes" $i>Да</option>
<option value="no" $g>Нет</option>
</select></td></tr>
</tr>
<tr>
<td>Путь до скрипта:</td>
<td><input type="text" name="rootdir" value="{$ROOTDIR}" /></td>
<td>Логгер атак:</td>
<td><select name="hlog">
<option value="no" $hln>Выкл</option>
<option value="yes" $hly>Вкл</option>
</select></td>
</tr>
<tr>
<td>Папка для логов:</td>
<td><input type="text" name="datadir" value="{$DATADIR}" /></td>
<td>Логгер обращений:</td>
<td><select name="rlog">
<option value="yes" $rly>Вкл</option>
<option value="no" $rln >Выкл</option>
</select></td>
</tr>
<tr>
<td>Папка с модулем:</td>
<td><input type="text" name="mod_dir" value="{$MODULEDIR}" /></td>
<td colspan="2"><p align="center">Опции сканирования</p></td>
</tr>
<tr>
<td>Табличка онлайна</td>
<td><input type="text" value="{$online}" name="ONLINE" /></td>
<td>Размер больше (байт) 0 для отключения фильтра:</td>
<td><input type="text" value="{$msize}" name="msize" /></td>
</tr>
<tr>
<td>Табличка антивиря:</td>
<td><input type="text" value="{$FILEBASE}" name="FILEBASE" /></td>
<td>Изменен меньше (дней) 0 для отключения фильтра :</td>
<td><input type="text" value="{$lchange}" name="lchange" /></td>
</tr>
<tr>
<td>Путь к файлу логов апача :</td>
<td><input type="text" value="{$alog}" name="alog" /></td>
<td>Просмотр лога за N-вчерашний день :</td>
<td><input type="text" value="{$tlog}" name="tlog" /></td>
</tr>
<tr>
<td>Табличка для логов:</td>
<td><input type="text" value="{$log}" name="LOG" /></td>
<td colspan="2"><p align="center"><input type="submit" value="Сохранить" name="save" /></p></td>
</tr>
</table>
		</form>
EOF;
    }
    else
    {
 foreach($_POST as $key => $value) 
 {
//ну давайте злые хачцекеры, ломайте=)
//28.03.2007 by NuR 	
 $value=trim($value);
    $value=str_replace("'","",$value);
     $value=str_replace("(","",$value);
      $value=str_replace(")","",$value);
       $value=str_replace('"',"",$value);
        $value=str_replace(";","",$value);
        $value=str_replace('\\',"",$value);
 $_POST[$key]=$value;
$$key=$value;
 }
        //($_POST['ddos'] == 'yes') ? $ddos = "true":$ddos = "false";
        $str = "<?php \n";
        $str .= "if( ! defined('IN_AH') ) die('error'); \n";
        $str .= "\$ddos['user'] = '" . $_POST['ddos_name'] . "'; \n";
        $str .= "\$ddos['pass'] = '" . $_POST['ddos_pass'] . "'; \n";
        $str .= "define('DDOS_LEVEL', '" . intval($_POST['ddoslvl']) . "');\n";
        $str .= "\$db['sql_host'] = '" . $db['sql_host'] . "';  \n";
        $str .= "\$db['sql_database']	= '" . $db['sql_database'] . "';  \n";
        $str .= "\$db['sql_user']	=	'" . $db['sql_user'] . "'; \n";
        $str .= "\$db['sql_pass']	=	'" . $db['sql_pass'] . "';   \n";
        $str .= "\$username = '" . $_POST['login'] . "'; \n";
        if ($_POST['pass']!='') $password=md5(md5($_POST['pass']));
		$str .= "\$password = '" . $password . "';\n";
		$str .= "define('ICQ','" . intval($_POST['icqq']) . "');\n";
        $str .= "define('TBL_LOG', '" . $_POST['LOG'] . "');\n";
        $str .= "define('TBL_ONLINE', '" . $_POST['ONLINE'] . "');\n";
        $str .= "define('FILEBASE', '" . $_POST['FILEBASE'] . "');\n";
        $str .= "define('DATADIR', '" . $_POST['datadir'] . "');\n";
        $str .= "define('ROOT_DIR', '" . $_POST['rootdir'] . "');\n";
        $str .= "define('SBASE', '" . $_POST['sbase'] . "'); \n";
        $str .= "define('MODULE_DIR', '" . $_POST['mod_dir'] . "');\n";
        $str .= "define('DEBUG_MODE', '" . $_POST['debug'] . "');\n";
        $str .= "define('MIN_SIZE', '" . intval($_POST['msize']) . "');\n";
        $str .= "define('LAST_CHANGE', '" . intval($_POST['lchange']) . "');\n";
        $str .= "define('HACK_LOGING', '" . $_POST['hlog'] . "');\n";
        $str .= "define('REQUEST_LOGING', '" . $_POST['rlog'] . "');\n";
        $str .= "define('APACH_LOGS', '" . $_POST['alog'] . "');\n";
        $str .= "define('TLOG', '" . intval($_POST['tlog']) . "');\n";
        $str .= "?>";
        $f = fopen('antihacker_cnf.php', "w");
        fwrite($f, $str);
        fclose($f);
        echo "Сохранение прошло успешно!";
    }
}
//
//end options
//
//функция добавления парметров для не фильтрации и прочей хуйни
function get_pages($count)
{
    if ($count < 30)
        return false;
    else
    {
        $all = ceil(($count / 30));
        for ($i = 0; $i < $all; $i++)
        {
            if (strstr($_SERVER['REQUEST_URI'], '?'))
                $ret .= "<a href=\"$_SERVER[REQUEST_URI]&page=" . ($i * 30) . "\">" . ($i + 1) .
                    "</a> / ";
            else
                $ret .= "<a href=\"$_SERVER[REQUEST_URI]?page=" . ($i * 30) . "\">" . ($i + 1) .
                    "</a> / ";
        }
        return $ret;
    }
}
function scan_dir($dir, $size)
{
    $array = array();
    if ($handle = @opendir($dir))
    {
        while (false !== $file = readdir($handle))
        {
            if ($file != "." and $file != "..")
            {
                if (is_dir($dir . '/' . $file))
                    $array[] = scan_dir($dir . '/' . $file, $size);
                else
                {
                    if (filesize($dir . '/' . $file) >= $size * 1024)
                        $array[] = $dir . '/' . $file;
                }
            }
        }
        closedir($handle);
        return $array;
    }
    else
        return 'Error opening dir ' . $dir;
}
function show_dir($array)
{
    $ret = array();
    foreach ($array as $k => $v)
    {
        if (is_array($v) and count($v))
            show_dir($v);
        elseif (is_array($v) and !count($v))
            continue;
        else
        {
            echo "
    		<div class=\"dot\" style=\"margin-bottom: 5px; font-weight:normal; text-align: left;\">
    		Файл: $v <br />
    		Размер: " . my_size(filesize($v)) . "<br />
    		Дата изменения: " . date('d.m.Y - H.i.s', filemtime($v)) . "<br />
    		Права: " . fileperms($v) . "<br />
    		</div>
    		";
        }
    }
}
function my_size($size)
{
    if ($size >= 1048576)
        $size = round($size / 1048576 * 100) / 100 . " MB";
    elseif ($size >= 1024)
        $size = round($size / 1024 * 100) / 100 . " KB";
    else
        $size = $size . " Bytes";
    return $size;
}
//
//antivirus class
//
//надо сделать поиск только по определённым расширениям
//сделал поиск по определённым расширениям и определяеться в настройках время изменения и минимальный размер файлов(кастамайз/// для производительности) by NuR
class antivirus
{
    var $files = array();
    var $i = 0;
    var $names = array('r57', 'shell', 'c99');
    function scan($dir)
    {
        $array = array();
        if ($handle = @opendir($dir))
        {
            while (false !== $file = readdir($handle))
            {
                if ($file != "." and $file != "..")
                {$dir_filename = $dir.'/'.$file;
                    if (is_dir($dir . '/' . $file))
                        {
						$this->scan($dir . '/' . $file);
						}
                    else
 						{
 						if ( preg_match( "#.*\.(php|cgi|pl|perl|php3|php4|php5|php6|phtml|php.7z)$#i", $file ) )
						{	
 						$scaned=0;
					//	$size  = filesize($file);
						$mtime    = filemtime($dir_filename);  
						$vrem = time() - 86400 * LAST_CHANGE;   	
						$msize=MIN_SIZE;	
						if(MIN_SIZE=='0' && LAST_CHANGE=='0' )
							{
							$this->check($dir . '/' . $file);
							}
						if(MIN_SIZE=='0' && LAST_CHANGE!='0' )
							{
								if($mtime<$vrem)
								{
								$this->check($dir . '/' . $file);
								}
							}
						if(MIN_SIZE!='0' && LAST_CHANGE=='0' )
							{
								if(filesize($dir_filename)>MIN_SIZE)
								{
								$this->check($dir . '/' . $file);
								}
							}	
							if(MIN_SIZE!='0' && LAST_CHANGE!='0' )
							{
							if(filesize($dir_filename)>MIN_SIZE)
								{
								if($mtime>$vrem)
								{	
								$this->check($dir . '/' . $file);
								}
								}
							}			
						//	$this->check($dir . '/' . $file);
						}
						}                   
                }
            }
        }
    }
function check($file)
    {
$size     = filesize($file);
$mtime    = filemtime($file);  
$vrem = time() - 86400 * LAST_CHANGE;   	
$msize=MIN_SIZE;
$file_sql = mysql_real_escape_string($file); //thx to ZXroot
        $zapros = "SELECT date,size FROM " . FILEBASE . " WHERE filee='$file_sql'";
        $result = mysql_query($zapros);
        if (mysql_num_rows($result) == 0)
        {
            if (filesize($file) >= 10)
            {
                $this->files[$this->i]['name'] = $file;
                $this->files[$this->i]['level'] += 2;
            }
            if (filesize($file) >= 80000)
            {
                $this->files[$this->i]['name'] = $file;
                $this->files[$this->i]['level'] += 3;
            }
            foreach ($this->names as $name)
            {
                if (stristr($file, $name))
                {
                    $this->files[$this->i]['name'] = $file;
                    $this->files[$this->i]['level'] += 20;
                }
            }
            static $base;//нех сто раз базу читать
            if (empty($base))
            {
                $base = file(SBASE);
            }
            $filedata = @file_get_contents($file);
			            foreach ($base as $lines)
            {	
                $test = trim($lines);//иначе ерег нах пошлёт
                if (preg_match("/$test/i", $filedata,$finded) AND $file!=ROOT_DIR."/".MODULE_DIR."/".SBASE) //fix by ZXroot
                {	
                    $this->files[$this->i]['level'] += 10;
                    $s=preg_replace("/\040/","",$finded[0]); //оптимизации данных для хранения в бд 26.03.2007 by NuR
                    $this->files[$this->i]['signature'] = $this->files[$this->i]['signature']."  ".mysql_real_escape_string(
htmlspecialchars($s));
                }
            }
            $ftime = date("Y.m.d  H:i:s.", $mtime);
            $baza = FILEBASE;
            $lvl = $this->files[$this->i]['level'];
            $signa=$this->files[$this->i]['signature'];
            $uid = stat($file);
            $ra='N\A';
            $posix = (stristr(php_uname(),'win')) ? 0 : 1; //проверка на чём крутиться сервак
            if ($posix==1)
            {
            unset($ra);
            $inf=posix_getpwuid($uid[4]);
            $ra=$inf['name']." (".$inf['gecos'].")";
            }
            $zapros = "INSERT INTO " . $baza . " (filee,date,size,level,signature,uid) VALUES ('$file_sql','$ftime','$size','$lvl','$signa','$ra')";
            mysql_query($zapros) or die(mysql_error());
            $this->i = $this->i + 1;
        }
        while ($row = mysql_fetch_array($result))
        {
            $ftime = date("Y.m.d  H:i:s.", $mtime);
            $baza = FILEBASE;
            $lvl = $this->files[$this->i]['level'];
            if ($row[date] != date("Y.m.d  H:i:s.", $mtime) and $row[date] !=filesize($file))
            {
                $zapros = "UPDATE " . $baza . " SET date='$ftime', size='$size',risk='high' WHERE filee='$file_sql'";
                mysql_query($zapros) or die(mysql_error());
            }
        }
    }
	}
?>
</td>
</td>
</TR>
</TABLE>