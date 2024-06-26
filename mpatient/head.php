<meta charset="utf-8"> 
<link rel="stylesheet" type="text/css" href="style.css"> 
<?php

   $re_name="/^[a-zA-ZöÖäÄüÜß]{1,30}$/";   // Regular Expression für Vorname und Nachname
   $re_svnr="/^\d{10}$/";         
   
   
   // Regular Expression für Sozialversicherungsnummer


   //$re_email="/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix"; 

   $re_email="/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/";

   $re_tel="/^[0-9\-\(\)\/\+\s]*$/";   



   $re_gewicht="/^\d{1,3}\.{0,2}\d{0,2}$/"; // Regular Expression für Gewicht
   $re_date="/^\d{4}-\d{2}-\d{2}$/";        // Regular Expression für Datum
      
   /* Verbindungsdaten für den Datenbankserver inkludieren (Achtung: Inhalt und Dateipfad anpassen)
   In der Datei data.php werden alle erforderlichen Variablen für den Datenbankzugang definiert: 
   <?php 
      $servername="localhost";
      $dbname="<Name der Datenbank>";
      $username="<Name des Datenbankbenutzers>"; 
      $password="<"Passwort des Datenbankbenutzers>"; 
   ?>
   */
   include("data.php"); //Dateipfad auf "data.php" ändern
 
   try // auf Fehler prüfen 
   {
      // Verbindung zum Datenbankserver aufbauen
      $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
      // Programmverhalten im Fehlerfall: Programm wird abgebrochen und der Fehler angezeigt
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo("Verbindung zur Datenbank war erfolgreich!");
   } 
   catch (PDOException $e) 
   {  // detaillierte Fehlermeldung
      echo ("<h2>Fehler beim Verbinden zum Datenbankserver</h2>in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
      die($e->getMessage()); 
   }

?>
