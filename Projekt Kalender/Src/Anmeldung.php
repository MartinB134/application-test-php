<!Doctype HTML>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

  	<h1>Anmeldung</h1>

      <form role="form" method="post" action="logindaten.php">
  		<div class="form-group" id="form">

  			<input type="text" required placeholder="Name" name="Name" id="name" class="form-name">
  			</div>

  			<div class="form-group">
  			<input type="text" required placeholder="Nachname" name="Nachname" id="Nachname" class="form-Nachname">
        </div>

  			<div class="form-group">
  			<input type="text" required placeholder="E-Mail" name="E-Mail" id="E-Mail" class="form-EMail">
  			</div>

  			<div class="form-group">
        <input type="submit" value="Anmelden" class="submit-btn" name="submit" id="submit">
        </div>
  	  </div>
      </form>

  <?php

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "users";


    $verbindung = mysqli_connect("localhost", "root", "")
  	or die("Keine Verbindung zum Server möglich.");

  	session_start();

  	mysqli_select_db($verbindung, "users")
  	or die("Verbindung zur Datenbank war nicht möglich...");
  	//print_r($_POST);

  	if(isset($_POST["name"])){

  		$name= $_POST["Name"];
  		$family= $_POST["Nachname"];
  		$email= $_POST["E-mail"];

  		if($family == "" or $email == ""  or $name == ""){
  			echo"Du hast die Felder nicht ausgefüllt...";
  		}
// In der Datenbank "users" wurde eine Tabelle mit "userdb" mit 3 Spalten eingerichtet


  				$eintrag="INSERT INTO userdb (name,family,email) VALUES ('$name', '$family','$email')";
  				$eintragen=mysqli_query($eintrag);

  				if($eintragen== true){
  					echo"Deine Daten wurde gespeichert";
  				}
  				else{
  					echo"Fehler im System. Konnte nicht gespeichert werden";

            if (!mysqli_query($verbindung, $sql ))
          		{
          			echo 'Nicht verbunden';
          			}
          		else
          			{
          			echo 'Verbunden!';
          			}

  				}
          header("refresh:1; url:Kalender.php");
  			}


  	mysqli_close($verbindung);
  	?>
</body>
</html>
