<?php
/*
Yves Glodt (yg@mind.lu) 13.01.2002
This is based on a calendar I found in the phpbuilder code library (http://phpbuilder.com/snippet/detail.php?type=snippet&id=22)
It still looks kinda similar, but behind the scenes, much has changed.
Some description is available at http://www.mind.lu/~yg/stuff/

19.02.2002 - Code cleanup and fixed error in getting the number of days in a month.

Ver 2.0 Changes
- Added Remarks for the Newbies like me.
- Made changes to the format and color.
- Added a Next and Previous button.
- Corrected the FORM so it works.  I had issues with it not submiting.

Next I will be adding a database function to it.


Changes:
---------
- The html actually validates.
- Changed form-method from "post" to "get", to simplify integration.
- All dates are handled correctly, the result looks always good and creates valid html.
- When the current month/year is shown, the current day is highlighted.
- The years-<select> is dynamic, it shows the selected year +/- 5 years.
- A light version, for embedding into existing pages is available. (http://www.mind.lu/~yg/stuff/)

*/

$CurDate = getdate();  //gets the server current date.
if (checkdate($HTTP_GET_VARS['month'],1,$HTTP_GET_VARS['year']) == NULL)
    {
    $YearToShow = $CurDate['year'];  // $YearToShow = $CurDate['year'];
    $MonthToShow = $CurDate['mon'];  // $MonthToShow = $CurDate['mon'];
    }
else
 {
    if (checkdate($HTTP_GET_VARS['month'],1,$HTTP_GET_VARS['year']) == false)
    {
        $YearToShow = $CurDate['year'];
        $MonthToShow = $CurDate['mon'];
    }
    else
    {
        $YearToShow = $HTTP_GET_VARS['year'];
        $MonthToShow = $HTTP_GET_VARS['month'];
        if ( ($YearToShow < 1902) || ($YearToShow > 2037) )
        {
            $YearToShow = $CurDate['year'];
            $MonthToShow = $CurDate['mon'];
        }
    }
}
// This checks to see if the current day will be displayed. If it is make the background a color.
if ( ($YearToShow == $CurDate['year']) && ($MonthToShow == $CurDate['mon']) ) { $DayToShow = $CurDate['mday'];  }
// This checks to see how many days are in the month in question.
$NumberOfDays = date(t,mktime(0,0,0,$MonthToShow+1,0,$YearToShow,-1));
// This section converts the month number to the month name.
$MonthNames = array(1=>'January','February','March','April','May','June','July','August','September','October','November','December');
//$Years = array('1998','1999','2000','2001','2002','2003','2004','2005');
$Years = array($YearToShow-5,$YearToShow-4,$YearToShow-3,$YearToShow-2,$YearToShow-1,$YearToShow,$YearToShow+1,$YearToShow+2,$YearToShow+3,$YearToShow+4,$YearToShow+5);
// Sets up the href
if ($MonthToShow == 12)
    {
        $pmon = ($MonthToShow - 1);
        $pyear = ($YearToShow);
        $nmon = (1);
        $nyear = ($YearToShow + 1);
    }
else
    {
    if ($MonthToShow == 1)
        {
        $pmon = (12);
        $pyear = ($YearToShow - 1);
        $nmon = ($MonthToShow + 1);
        $nyear = ($YearToShow);
        }
    else
        {
        $pmon = ($MonthToShow - 1);
        $pyear = ($YearToShow);
        $nmon = ($MonthToShow + 1);
        $nyear = ($YearToShow);
        }
    }

echo <<<EOT
<table border="1" cellpadding="0" cellspacing="0" bordercolor=black>
<tr><td colspan="7" align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="20%"><font color="#000000" size="4" face="Times New Roman, Times, serif">$MonthNames[$MonthToShow] $YearToShow</font></td>
    <td width="30%" align="right">

    <a href=$PHP_SELF?month=$pmon&year=$pyear>&lt;&lt; previous</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href=$PHP_SELF?month=$nmon&year=$nyear>next &gt;&gt;</a>

    </td>
    <td align="right" width="50%"><form action="$PHP_SELF" method="get">
<font size="2" face="Times New Roman, Times, serif">Month</font><select name="month">
EOT;
while (list($key,$value) = each($MonthNames))
{
    if ($key != $MonthToShow) { print '<option value="'.$key.'">'.$value."</option>\n"; }
    else { print '<option value="'.$key.'" selected>'.$value."</option>\n"; }
}
print "</select>\nYear<select name=\"year\">\n";
while (list($key,$value) = each($Years))
{
    if ($value != $YearToShow) { print '<option value="'.$value.'">'.$value."</option>\n"; }
    else { print '<option value="'.$value.'" selected>'.$value."</option>\n"; }
}
echo <<<EOT
</select>
<input type="submit" value="Go"></td>
  </tr>
</table>



</td></tr>
<tr>
    <td width="100" align="center" bgcolor="#CC0000"><font color="#FFFFFF"><strong>Sunday</strong></font></td>
    <td width="100" align="center" bgcolor="#CC0000"><font color="#FFFFFF"><strong>Monday</strong></font></td>
    <td width="100" align="center" bgcolor="#CC0000"><font color="#FFFFFF"><strong>Tuesday</strong></font></td>
    <td width="100" align="center" bgcolor="#CC0000"><font color="#FFFFFF"><strong>Wednesday</strong></font></td>
    <td width="100" align="center" bgcolor="#CC0000"><font color="#FFFFFF"><strong>Thursday</strong></font></td>
    <td width="100" align="center" bgcolor="#CC0000"><font color="#FFFFFF"><strong>Friday</strong></font></td>
    <td width="100" align="center" bgcolor="#CC0000"><font color="#FFFFFF"><strong>Saturday</strong></font></td>
</tr>
EOT;
$FirstDayOfWeek = date(l,mktime(0,0,0,$MonthToShow,1,$YearToShow));
// This section ofsets the first day of the month so it matches the day of week.
switch ($FirstDayOfWeek) {
    case 'Monday':
        $offset = 1;
    break;
    case 'Tuesday':
        $offset = 2;
    break;
    case 'Wednesday':
        $offset = 3;
    break;
    case 'Thursday':
        $offset = 4;
    break;
    case 'Friday':
        $offset = 5;
    break;
    case 'Saturday':
        $offset = 6;
    break;
    default:
        $offset = 0;
}
// this covers the first few empty days.
if ($offset > 0) {
    print "<tr height=100 valign=top>";
    echo str_repeat("<td bgcolor=000000>&nbsp;</td>",$offset);
}
// This section is to Allow the first day of the week to be sunday and also.
// to make sure that the table prints out right.
for ($i=1; $i <= $NumberOfDays; $i++) {
    $DayOfWeek = date(l,mktime(0,0,0,$MonthToShow,$i,$YearToShow));
    if($DayOfWeek == 'Sunday') {
        print "<tr height=100 valign=top>";
    }
    if ($i != $DayToShow) {
        print "<td>$i</td>";
    } else {
        print "<td bgcolor=yellow>$i</td>";
    }
    if($DayOfWeek == 'Saturday') {
        print "</tr>\n";
    }
}
// This section will fill in the blank spaces.
// The first part covers Feb.
if ( ( ($offset == 5) && ($NumberOfDays > 30) ) || ( ($offset == 6) && ($NumberOfDays > 29) ) ) {
    if (42-$NumberOfDays-$offset > 0) {
        echo str_repeat("<td bgcolor=000000 class=\"n\">&nbsp;</td>\n",42-$NumberOfDays-$offset);
    }
    print "</tr>\n";
} elseif ( ($NumberOfDays != 28) || ($offset > 0) ) {
    if (35-$NumberOfDays-$offset > 0) {
        echo str_repeat("<td bgcolor=000000 class=\"n\">&nbsp;</td>\n",35-$NumberOfDays-$offset);
    print "</tr>\n";
    }
}
echo <<<EOT
</table>
EOT;
?>
