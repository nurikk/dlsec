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

if (!defined('IN_AH'))
    die('error');
require ('antihacker_cnf.php');
$icq = ICQ;
$dir=MODULE_DIR;
?>
<link rel="stylesheet" content="text/css" href="<? echo($dir); ?>/style.css">
<title>DLSecure Module [DaMaGeLaB.OrG] -> Security Alert</title>

<BODY>
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 ALIGN=CENTER>
<TR>
<TD HEIGHT=100% ALIGN=CENTER VALIGN=MIDDLE>
<TABLE WIDTH=700 BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD VALIGN=TOP class="new">
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD HEIGHT=15 class="titl">
<A HREF="http://damagelab.org" class="atitl">DLSecure Module [DaMaGeLaB.OrG] -> Security Alert</A></TD>
</TR>
<TR>
<td class="styl">
Обнаружена попытка проникновения!<br>
Ваш IP (<?=$_SERVER['REMOTE_ADDR'] ?>) был занесен в логи. Администратор будет извещен о попытке взлома.<br>
Если Вы считаете, что ошибка вызвана не Вами - сообщите администрации (icq# <?=$icq ?>)<br>код ошибки (указан в текстовом поле ниже)<br>
----------------------------------------<br>Hacking attempt has been detected.<br>Your IP (<?=$_SERVER['REMOTE_ADDR'] ?>) has been logged and will be sent to administrator.<br>If you really consider that it's not your fault, please, send the error code (following in the textarea)<br>to administrator (icq# <?=$icq ?>)<br><br>
<img src="<? echo($dir); ?>/stop.gif" border="0"><br><br>
Информация о попытке взлома может быть передана компетентным людям. Будте осторожны.<br>
Атака отражена успешно.<br><br>
<b>Код ошибки / Error code:</b><br>
<textarea cols=70 rows=5 style="background-color:000000;color:white;">
<?=htmlspecialchars($reason)?>
</textarea></td></td>
</TR></TABLE>
</body>