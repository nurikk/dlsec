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
include ("antihacker_cnf.php");
if (DEBUG_MODE == 'no')
    die('error');
Error_Reporting(0);
preg_match("/Bad: (.*)=/i", $reason, $pat_array);
//print_r($pat_array);
//$inc = $pat_array[1];
//echo ($pat_array[1]);
$var = 'test';
$tr = 'werwe';

if ($_POST['add'] == 'allow')
    add_allow($pat_array[1]);
if ($_POST['add'] == 'cust')
    add_cust($pat_array[1], $_POST['kustom']);

//add_cust($var,$tr);
function add_allow($var)
{

    require ("variables.php");


    $config = "<?php \n";
    $config .= "\$bad_sql = array(";
    echo ($reason);

    $cnt = count($bad_sql);
    $i = 0;
    foreach ($bad_sql as $vuln)
    {
        if ($i <> $cnt)
        {
            $config .= '"' . $vuln . '",';

        }
        if ($i == $cnt)
        {
            $config .= '"' . $vuln . '"';

        }
        $i++;

    }
    $config .= ");\n";
    $cnt = count($bad_include);
    $i = 0;
    $config .= '$bad_include = array(';
    $cnt = count($bad_include);
    foreach ($bad_include as $vuln)
    {

        if ($i <> $cnt)
        {
            $config .= '"' . $vuln . '",';

        }
        if ($i == $cnt)
        {
            $config .= '"' . $vuln . '"';

        }
        $i++;

    }
    $config .= ");\n";

    $config .= '$bad_xss = array(';
    $cnt = count($bad_xss);
    $i = 0;
    foreach ($bad_xss as $vuln)
    {

        if ($i <> $cnt)
        {
            $config .= '"' . $vuln . '",';

        }
        if ($i == $cnt)
        {
            $config .= '"' . $vuln . '"';

        }
        $i++;

    }
    $config .= ");\n";
    $config .= '$allow = array(';
    $cnt = count($allow);
    $i = 0;

    foreach ($allow as $vuln)
    {

        if ($i < $cnt - 1)
        {
            $config .= '"' . $vuln . '",';

        }
        $i++;
        if ($i == $cnt)
        {
            $config .= '"' . $vuln . '",';
            $config .= '"' . $var . '");' . "\n";

        }

    }

    //print_r($allow_custom);
    $cnt = count($allow_custom);
    $i = 0;
    $config .= "$allow_custom = array(";

    foreach ($allow_custom as $index => $value)
    {
        $i++;
        if ($i <> $cnt)
        {
            $config .= '"' . $index . '"=>';

            foreach ($value as $val)
                $config .= 'array("' . $val . '"),';
        }
        if ($i == $cnt)
        {
            $config .= '"' . $index . '"=>';
            foreach ($value as $val)
                $config .= 'array("' . $val . '"' . "));" . '\n';
        }

    }

    //  $config .= '"' . $inc . '"' . ')' . ";\n";
    $config .= "?>" . "\n";
    $f = fopen("variables.php", "w");

    fwrite($f, $config);
    fclose($f);
    echo "Сохранение прошло успешно!\n";
    //  unset($reason);

}

function add_cust($var, $type)
{

    require ("variables.php");
    

    $config = "<?php \n";
    $config .= "\$bad_sql = array(";
    echo ($reason);

    $cnt = count($bad_sql);
    $i = 0;
    foreach ($bad_sql as $vuln)
    {
        if ($i <> $cnt)
        {
            $config .= '"' . $vuln . '",';

        }
        if ($i == $cnt)
        {
            $config .= '"' . $vuln . '"';

        }
        $i++;

    }
    $config .= ");\n";

    $i = 0;
    $config .= '$bad_include = array(';
    $cnt = count($bad_include);
    foreach ($bad_include as $vuln)
    {

        if ($i <> $cnt)
        {
            $config .= '"' . $vuln . '",';

        }
        if ($i == $cnt)
        {
            $config .= '"' . $vuln . '"';

        }
        $i++;

    }
    $config .= ");\n";

    $config .= '$bad_xss = array(';
    $cnt = count($bad_xss);
    $i = 0;
    foreach ($bad_xss as $vuln)
    {

        if ($i <> $cnt)
        {
            $config .= '"' . $vuln . '",';

        }
        if ($i == $cnt)
        {
            $config .= '"' . $vuln . '"';

        }
        $i++;

    }
    $config .= ");\n";
    $config .= '$allow = array(';
    $cnt = count($allow);
    $i = 0;

    foreach ($allow as $vuln)
    {

        if ($i <> $cnt - 1)
        {
            $config .= '"' . $vuln . '",';

        }
        $i++;
        if ($i == $cnt)
        {
            $config .= '"' . $vuln . '");' . "\n";

        }

    }

    $cnt = count($allow_custom);
    $i = 0;
    $config .= '$allow_custom = array(';

    foreach ($allow_custom as $index => $value)
    {
        $i++;

        if ($i <> $cnt)
        {
            $config .= '"' . $index . '"=>';

            foreach ($value as $val)
                $config .= 'array("' . $val . '"),';
        }
        if ($i == $cnt)
        {
            $config .= '"' . $index . '"=>';
            foreach ($value as $val)
                $config .= 'array("' . $val . '"),' . "\n";
            $config .= '"' . $var . '"=>array("' . $type . '"));';
        }

    }

    $config .= "?>" . "\n";
    $f = fopen("variables.php", "w");

    fwrite($f, $config);
    fclose($f);
    echo '<link rel="stylesheet" content="text/css" href="style.css">
<title>DLSecure Module [DaMaGeLaB.OrG] -> Debug mooD -> Add variable</title>

<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 ALIGN=CENTER>
<TR>
<TD HEIGHT=100% ALIGN=CENTER VALIGN=MIDDLE>
<TABLE WIDTH=450 BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD VALIGN=TOP class="new">
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD HEIGHT=15 class="titl">
<A HREF="http://damagelab.org" class="atitl">DLSecure Module [DaMaGeLaB.OrG] -> Debug mooD -> Add variable</A></TD>
</TR>
<TR>
<td class="styl">
<b>Переменная успешно добавлена в макросы<br>
<a class="styl" href="admin.php" target="_top">Перейти в админцентр</a></b><br><br>
<a class="styl" href="http://damagelab.org" target="_top">Посетить DaMaGeLaB.OrG</a>

</td></td>
</TR></TABLE>';

}





?>



