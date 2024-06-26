

<?
error_reporting(-1);

// select.php
echo "<b>Patienten-Daten anzeigen:</b><br><br>";

// Verbindungsdaten inkludieren
include("data.php");

// Verbindung zum Datenbankserver aufbauen
$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
   
// Programmverhalten im Fehlerfall: Programm wird abgebrochen und der Fehler angezeigt
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// SQL-Abfrage festlegen
$statement="select * from patient";
   
// SQL-Abfrage durchführen
$sql = $conn->prepare($statement);
$sql->execute();

// Ergebnis der SQL-Abfrage in Assoziatives Array speichern
$patienten_liste = $sql->fetchAll(PDO::FETCH_ASSOC);

// alle Patienten (= alle Datensätze) anzeigen
foreach ($patienten_liste as $row => $ein_patient) 
{ 
   // einen Patient (= einen Datensatz) anzeigen
   echo " Id: ".$ein_patient['id'];
   echo " Vorname: ".$ein_patient['vorname'];
   echo " Nachname: ".$ein_patient['nachname'];
   echo " Geburt: ".$ein_patient['geburt'];
   echo " Gewicht: ".$ein_patient['gewicht']."<br>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Patienten-Daten anzeigen</title>
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

