
<!--
Es fehlt: - Die Einbettung der Termine.
          - die Verbindung mit dem mysql-Server und der Vermittlertabelle (junction-object), welche Nutzer und Termine gemeinsam speichert
          - Anfrage an den Server zur [Darstellung des Termins] [in der relevanten Farbe] [je nach Typ] [an dem definierten Zeitpunkt] [mit den zugehörigen Usern]
          - Button zum wechsel zur Tagesansicht
          - Tagesansicht
          - Button mit dem Link zur Terminerstellung

          Folgender PHP-Code wurde aus einem Tutorial übernommen. -->


<?php
date_default_timezone_set('Europe/Berlin');

// Get prev & next month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // This month
    $ym = date('Y-m');
}

// Check format
$timestamp = strtotime($ym."-01");
if ($timestamp === false) {
    $timestamp = time();
}

// Today
$today = date('j-m-Y', time());

// For H3 title
$html_title = date('m / Y', $timestamp);

// Create prev & next month link     mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

// Number of days in the month
$day_count = date('t', $timestamp);

// 0:Sun 1:Mon 2:Tue ...
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));


// Create Calendar!
$weeks = array();
$week = '';

// Add empty cell
$week .= str_repeat('
<td></td>

', $str);

for ( $day = 1; $day <= $day_count; $day++, $str++) {

    $date = $ym.'-'.$day;

    if ($today == $date) {
        $week .= '
<td class="today">
'.$day;
    } else {
        $week .= '
<td>'.$day;
    }
    $week .= '</td>

';

    // End of the week OR End of the month
    if ($str % 7 == 6 || $day == $day_count) {

        if($day == $day_count) {
            // Add empty cell
            $week .= str_repeat('
<td></td>

', 6 - ($str % 7));
        }

        $weeks[] = '
<tr>'.$week.'</tr>

';

        // Prepare for new week
        $week = '';

    }

}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>PHP Calendar</title>
     <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/Kalender-bootstrap.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700" rel="stylesheet">

</head>
<body>

<div class="container">

<h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>



<table class="table table-bordered">

<tr>

<th>S</th>

<th>M</th>

<th>T</th>

<th>W</th>

<th>T</th>

<th>F</th>

<th>S</th>

            </tr>

            <?php foreach ($weeks as $week) { echo $week; } ?>
        </table>

    </div>


</body>
</html>
