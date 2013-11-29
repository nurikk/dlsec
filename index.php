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
require('antihacker_cnf.php');
  session_start();
      if((@$user_name==$username)&&(md5(md5($user_pass))==$password)) //здраствуй вася=)
	  {
        $logged_user = $user_name;
        session_register("logged_user");
        header("Location: admin.php");
        exit;
      }
?>
<?php
	function clear($str)
{
    $str = urldecode($str);
    $str = htmlspecialchars($str);
    return $str;
}
echo ('
<link rel="stylesheet" content="text/css" href="style.css">
<title>DLSecure Module [DaMaGeLaB.OrG] -> Вход в панель администрирования</title>
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 ALIGN=CENTER>
<TR>
<TD HEIGHT=100% ALIGN=CENTER VALIGN=MIDDLE>
<TABLE WIDTH=350 BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD VALIGN=TOP class="new">
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD HEIGHT=15 class="titl">
<A HREF="http://damagelab.org" class="atitl">DLSecure Module [DaMaGeLaB.OrG] -> Авторизация</A></TD>
</TR>
<TR>
<td class="styl">

<form action="'.clear($_SERVER["PHP_SELF"]).'" method="post">
<table align="CENTER">
<tr>
	<td><font color="#FF552A">Логин:</font></td>
	<td><input type="text" name="user_name"><br></td>
</tr>
<tr>
	<td><font color="#FF552A">Пароль:</font></td>
	<td><input type="password" name="user_pass"><br></td>
</tr>

</table>
<input type="submit" name="Submit">
 </form> 
   
  
   
  
<a class="styl" href="http://damagelab.org" target="_top">Посетить DaMaGeLaB.OrG</a>
</td></td>
</TR></TABLE>

');
?>