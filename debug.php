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



require ('antihacker_cnf.php');

if(DEBUG_MODE=="no")
{
exit;
}

$dir = MODULE_DIR;
$text=htmlspecialchars($reason);
echo <<< HTML

<link rel="stylesheet" content="text/css" href="$dir/style.css">
<title>DLSecure Module [DaMaGeLaB.OrG] -> Security Alert [Debug mooD]</title>

<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 ALIGN=CENTER>
<TR>
<TD HEIGHT=100% ALIGN=CENTER VALIGN=MIDDLE>
<TABLE WIDTH=700 BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD VALIGN=TOP class="new">
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD HEIGHT=15 class="titl">
<A HREF="http://damagelab.org" class="atitl">DLSecure Module [DaMaGeLaB.OrG] -> Security Alert [Debug mooD]</A></TD>
</TR>
<TR>
<td class="styl">
�������� ���������� �� ��������� ��������!<br>
<form action="$dir/add.php" method="post">
<b>�������� ������:</b>
        <br />
<table border="0" align="center">
    <tr>
        <td style="color:000000;">������������ ���:</td>
        <td><select name="add"> 
        <option value="deny" >���</option>
		<option value="allow">�� �����������</option>
		<option value="cust">����������� ���</option>
		</select>
   <input type="hidden" value="$text" name="reason" /></td>
    </tr>
    <tr>
        <td style="color:000000;">����������� ��������:</td>
        <td><input type="text" value="��� ����� �������" name="kustom" /></td>
    </tr>
</table>



<br>
<input type="submit" value="���������" />
</form>

<b>��� ������ / Error code:</b><br>
<textarea cols=70 rows=5 style="background-color:000000;color:white;">
$text;
</textarea>
<br>
������������� ��������� debug mood �� ���������� ��������.<br>�� �������� debug mood � ��������� ������ ������ �������.
</td>
</TR></TABLE>
HTML;

?>


