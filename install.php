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
$sql[] = "CREATE TABLE `warning_log` (
  `id` int(11) NOT NULL auto_increment,
  `dateline` int(10),
  `query_string` text,
  `ip` varchar(16),
  `browser` varchar(200),
  `http_referer` varchar(255),
  `type` enum('sql','include','xss'),
   PRIMARY KEY (`id`)
) TYPE = MyISAM;";

$sql[] = "CREATE TABLE `online` (
  `id` int(11) NOT NULL auto_increment,
  `ip_addr` varchar(16) NOT NULL,
  `browser` varchar(255),
  `uri` text,
  `dateline` int(10),
   PRIMARY KEY (`ip_addr`, `id`)
) TYPE = MyISAM;";


$sql[] = "CREATE TABLE `antiviral` (
  `filee` varchar(255) NOT NULL default '',
  `date` varchar(255) NOT NULL default '',
  `size` varchar(255) NOT NULL default '',
  `level` int(50) NOT NULL default '0',
  `risk` varchar(255) NOT NULL default '',
  `signature` varchar(255) NOT NULL default '',
  `uid` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`filee`)
) TYPE=MyISAM;";



foreach($sql as $sql) mysql_query($sql, $conn_id) or die(mysql_error());

die('<link rel="stylesheet" content="text/css" href="style.css">
<title>DLSecure Module [DaMaGeLaB.OrG] -> »нсталл€ци€</title>

<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 ALIGN=CENTER>
<TR>
<TD HEIGHT=100% ALIGN=CENTER VALIGN=MIDDLE>
<TABLE WIDTH=350 BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD VALIGN=TOP class="new">
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD HEIGHT=15 class="titl">
<A HREF="http://damagelab.org" class="atitl">DLSecure Module [DaMaGeLaB.OrG] -> »нсталл€ци€</A></TD>
</TR>
<TR>
<td class="styl">
<b>»нсталл€ци€ успешно завершена<br>
<a class="styl" href="admin.php" target="_top">ѕерейти в админцентр</a></b><br><br>
<a class="styl" href="http://damagelab.org" target="_top">ѕосетить DaMaGeLaB.OrG</a>

</td></td>
</TR></TABLE>');

?>
