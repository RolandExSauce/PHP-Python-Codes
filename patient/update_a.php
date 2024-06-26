

<!DOCTYPE html>
<html><!-- update_a.php -->
<head>
<title>Patienten-Daten ändern</title>
<meta charset="UTF-8">
</head>
<body>
<?
$id=$_GET['id'];
echo "<p><b>Patienten-Daten mit Id=$id ändern:</b></p>";

// Verbindungsdaten inkludieren
include("data.php");
   
// Verbindung zum Datenbankserver aufbauen
$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
   
// Programmverhalten im Fehlerfall: Programm wird abgebrochen und der Fehler angezeigt
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['c_knopf']))
{
   $vn=$_POST['vorname'];
   $nn=$_POST['nachname'];
   $geb=$_POST['geburt'];
   $gew=$_POST['gewicht'];

   // SQL-Abfrage festlegen
   $statement="update patient set vorname='$vn',nachname='$nn',geburt='$geb',gewicht='$gew'
                  where id='$id'";
   
   // SQL-Abfrage durchführen
   $sql = $conn->prepare($statement);
   $sql->execute();
			
   // alles in Ordnung
   echo("<p>Die Patienten-Daten wurden erfolgreich geändert !</p>");
}
else
{
   $statement="select * from patient where id='$id'";
   
   // SQL-Abfrage durchführen
   $sql = $conn->prepare($statement);
   $sql->execute();
   
   // Ergebnis der SQL-Abfrage in Assoziatives Array speichern
   $patienten_liste = $sql->fetchAll(PDO::FETCH_ASSOC);
   
   // den Patienten anzeigen ... nur ein Schleifendurchlauf
   foreach ($patienten_liste as $row => $der_patient) 
   { 
      // einen Patient (= einen Datensatz) anzeigen
      $id=$der_patient['id'];
      $vn=$der_patient['vorname'];
      $nn=$der_patient['nachname'];
      $geb=$der_patient['geburt'];
      $gew=$der_patient['gewicht'];
   }
}
?>

<form action="./update_a.php?id=<?=$id?>" method=post>
Vorname
<input type="text" name="vorname" size="8" maxlength="20" value="<?=$vn?>">
Nachname
<input type="text" name="nachname" size="8" maxlength="20" value="<?=$nn?>">
Geburtsdatum
<input type="text" name="geburt" size="8" maxlength="10" value="<?=$geb?>">
Gewicht
<input type="text" name="gewicht" size="6" maxlength="6" value="<?=$gew?>">
<input type="submit" name="c_knopf" value="Ändern">
</form>
<p>
<a href="./insert.php">Patienten-Daten erfassen</a><br>
<a href="./select.php">Patienten-Daten anzeigen</a><br>
<a href="./update.php">Patienten-Daten ändern</a><br>
<a href="./delete.php">Patienten-Daten löschen</a>
</p>
</body>
</html>

