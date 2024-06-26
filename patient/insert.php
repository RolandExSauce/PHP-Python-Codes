

<!DOCTYPE html>
<html><!-- insert.php -->
<head>
<title>Patienten-Daten erfassen</title>
<meta charset="UTF-8">
</head>
<body>
<p><b>Patienten-Daten erfassen:</b></p>
<?
$vn=$nn=$geb=$gew="";

if (isset($_POST['n_knopf']))
{
   $vn=$_POST['vorname'];
   $nn=$_POST['nachname'];
   $geb=$_POST['geburt'];
   $gew=$_POST['gewicht'];

   // Verbindungsdaten inkludieren
   include("data.php");
   
   // Verbindung zum Datenbankserver aufbauen
   $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
   
   // Programmverhalten im Fehlerfall: Programm wird abgebrochen und der Fehler angezeigt
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // SQL-Abfrage festlegen
   $statement="insert into patient (vorname,nachname,geburt,gewicht) values ('$vn','$nn','$geb','$gew');";
   
   // SQL-Abfrage durchführen
   $sql = $conn->prepare($statement);
   $sql->execute();
			
   // alles in Ordnung
   echo("<p>Der Patient wurde erfolgreich hinzugefügt !</p>");
}
?>

<form action="./insert.php" method=post>
Vorname
<input type="text" name="vorname" size="8" maxlength="20" value="<?=$vn?>">
Nachname
<input type="text" name="nachname" size="8" maxlength="20" value="<?=$nn?>">
Geburtsdatum
<input type="text" name="geburt" size="8" maxlength="10" value="<?=$geb?>">
Gewicht
<input type="text" name="gewicht" size="6" maxlength="6" value="<?=$gew?>">
<input type="submit" name="n_knopf" value="Hinzufügen">
</form>
<p>
<a href="./insert.php">Patienten-Daten erfassen</a><br>
<a href="./select.php">Patienten-Daten anzeigen</a><br>
<a href="./update.php">Patienten-Daten ändern</a><br>
<a href="./delete.php">Patienten-Daten löschen</a>
</p>
</body>
</html>

