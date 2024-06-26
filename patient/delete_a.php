

<?
// delete_a.php
echo "<b>Patienten-Daten löschen:</b>";

// GET-Variable id aus URL ermitteln
$id=$_GET['id'];
   
// Verbindungsdaten inkludieren
include("data.php");
   
// Verbindung zum Datenbankserver aufbauen
$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
   
// Programmverhalten im Fehlerfall: Programm wird abgebrochen und der Fehler angezeigt
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// SQL-Abfrage festlegen
$statement="delete from patient where id='$id'";
   
// SQL-Abfrage durchführen
$sql = $conn->prepare($statement);
$sql->execute();
			
// alles in Ordnung
echo("<p>Der Patienten-Daten mit der Id=$id wurden erfolgreich gelöscht !</p>");
?>

<!DOCTYPE html>
<html>
<head>
<title>Patient löschen</title>
<meta charset="UTF-8">
</head>
<body>
<p>
<a href="./insert.php">Patienten-Daten erfassen</a><br>
<a href="./select.php">Patienten-Daten anzeigen</a><br>
<a href="./update.php">Patienten-Daten ändern</a><br>
<a href="./delete.php">Patienten-Daten löschen</a>
</p>
</body>
</html>

