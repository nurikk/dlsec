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

define('IN_AH', true);
require 'antihacker_cnf.php';
$conn_id = mysql_connect($db['sql_host'], $db['sql_user'], $db['sql_pass']) or die(mysql_error());
mysql_select_db($db['sql_database']) or die(mysql_error());

$sql[] = 'ALTER TABLE `antiviral` ADD `signature` VARCHAR(255) NOT NULL, ADD `uid` VARCHAR(10) NOT NULL';



foreach($sql as $sql) mysql_query($sql, $conn_id) or die(mysql_error());

die('<link rel="stylesheet" content="text/css" href="style.css">
<title>DLSecure Module [DaMaGeLaB.OrG] -> Обновление до 0.0.1.3</title>

<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 ALIGN=CENTER>
<TR>
<TD HEIGHT=100% ALIGN=CENTER VALIGN=MIDDLE>
<TABLE WIDTH=350 BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD VALIGN=TOP class="new">
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD HEIGHT=15 class="titl">
<A HREF="http://damagelab.org" class="atitl">DLSecure Module [DaMaGeLaB.OrG] -> Обновление до 0.0.1.2</A></TD>
</TR>
<TR>
<td class="styl">
<b>Обновление SQL базы успешно завершено. Текущая версия структуры SQL базы: 0.0.1.2<br>
<a class="styl" href="admin.php" target="_top">Перейти в админцентр</a></b><br><br>
<a class="styl" href="http://damagelab.org" target="_top">Посетить DaMaGeLaB.OrG</a>

</td></td>
</TR></TABLE>');

?>
