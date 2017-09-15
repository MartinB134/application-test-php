<!doctype html>
<charset="UTF-8">
<html>
<head>
  <title>Termin Erstellung</title>
</head>
<body><h1>Termine</h1>

<?php
  CREATE TABLE `termine` (
    `id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `datum` DATE NOT NULL ,
    `titel` VARCHAR( 256 ) NOT NULL ,
    `beschreibung` BLOB NOT NULL
  ) ENGINE = MYISAM ;
?>


</body>




</html>
