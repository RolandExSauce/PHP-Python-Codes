<?php
// myclass.php
// Definition der Regular Expressions (Reguläre Ausdrücke) für die GUI als globale Variablen
$re_name="/^[a-zA-ZöÖäÄüÜß]{1,30}$/";    // Regular Expression für Vorname und Nachname
$re_svnr="/^\d{10}$/"; // Regular Expression für Sozialversicherungsnummer
$re_email="/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/";
$re_tel="/^[0-9\-\(\)\/\+\s]*$/";
$re_gewicht="/^\d{1,3}\.{0,2}\d{0,2}$/"; // Regular Expression für Gewicht
$re_date="/^\d{4}-\d{2}-\d{2}$/";        // Regular Expression für Datum

class RloulengoPatient
{
   //Definitionen der privaten globalen Klassenvariablen
   //Datenbank-Handle
   private $conn;
   
   //Ergebnis der SQL-Abfrage
   private $sql;
   
   // Definitionen der öffentlichen Methoden
   function RloulengoPatient() //verbindet sich zum Datenbankserver und liefert den DB-Handle zurück
   {
      /* Verbindungsdaten für den Datenbankserver inkludieren (Achtung: Inhalt und Dateipfad anpassen)
      In der Datei data.php werden alle erforderlichen Variablen für den Datenbankzugang definiert: 
      <?php 
         $servername="localhost";
         $dbname="<Name der Datenbank>";
         $username="<Name des Datenbankbenutzers>"; 
         $password="<"Passwort des Datenbankbenutzers>"; 
      ?>
      */
      include("../data.php"); //Dateipfad auf "data.php" ändern
 
      try // auf Fehler prüfen 
      {
         // Verbindung zum Datenbankserver aufbauen
         $this->conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
         // Programmverhalten im Fehlerfall: Programm wird abgebrochen und der Fehler angezeigt
         $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } 
      catch (PDOException $e) 
      {  // detaillierte Fehlermeldung
         echo ("<h2>Fehler beim Verbinden zum Datenbankserver</h2>");
         echo ("in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
         die($e->getMessage()); 
      }
   
      $this->conn;
   }

   // SQL-Abfrage durchführen
   function rloulengo_dbserver_query($statement)
   {
      try
      {
         $this->sql = $this->conn->prepare($statement);
         $this->sql->execute();
      }
      catch (PDOException $e) 
      {  // detaillierte Fehlermeldung
         echo("<h2>Fehler bei der Datenbankabfrage</h2>in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
         die($e->getMessage()); 
      }
      
      $this->sql;
   }

   //Returns the number of rows affected by the last SQL statement
   function rloulengo_dbserver_rowCount() 
   {
      try // auf Fehler prüfen 
      {
         return $this->sql->rowCount();
      }
      catch (PDOException $e) 
      {  // detaillierte Fehlermeldung
         echo ("<h2>Fehler bei der Ermittlung der betroffenen Zeilen</h2>");
         echo ("in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
         die($e->getMessage()); 
      }
   }

   //Returns the ID of the last inserted row or sequence value  
   function rloulengo_dbserver_lastInsertId() 
   {
      try // auf Fehler prüfen 
      {
         return $this->conn->lastInsertId();
      }
      catch (PDOException $e) 
      {  // detaillierte Fehlermeldung
         echo ("<h2>Fehler bei der Ermittlung der aktuellen Personen-ID </h2>");
         echo ("in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
         die($e->getMessage()); 
      }
   }

   //Fetches the remaining rows from a result set  
   function rloulengo_dbserver_fetchAll() 
   {
      try // auf Fehler prüfen 
      {
         return $this->sql->fetchAll(PDO::FETCH_ASSOC);;
      }
      catch (PDOException $e) 
      {  // detaillierte Fehlermeldung
         echo ("<h2>Fehler bei der Ermittlung der Ergebnis-Zeilen </h2>");
         echo ("in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
         die($e->getMessage()); 
      }
   }

   // alle Krankheiten der Person in die Tabelle pa_besitzt speichern
   function rloulengo_dbserver_insert_diseases($person_fid,$krankheit) 
   {
      // jede Krankheit als einzelnen Datensatz in die Tabelle pa_besitzt eintragen
      foreach ($krankheit as $row => $krankheit_fid)
      {
         $statement="insert into rloulengo_besitzt (person_fid,krankheit_fid) values ('$person_fid','$krankheit_fid');";
         $this->rloulengo_dbserver_query($statement);  // SQL-Abfrage durchführen
      }
   }
   
   // prüft den Text auf den vorgegebenen Regular Expression
   function rloulengo_check_regexp($feldname,$re_muster,$text) 
   {
      if (!preg_match($re_muster,$text)) // formale Prüfung 
      {
         echo("<h2>Ungültige Eingabe für '$feldname'.</h2>");
         die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
      }
   }

   // Fehlerausgabe bezüglich der GUI
   function rloulengo_gui_error($feldname) 
   {
       echo("<h2>Ungültige Eingabe für '$feldname'.</h2>");
       die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
   }

   // Zahl zwischen 1 bis 7 für die Essgewohnheiten ermitteln
   function rloulengo_calc_foodnumber($essen)  
   {
      $essen_value=0; // Vorbelegung für die Summenbildung
            
      foreach ($essen as $key => $value) // Gesamtwert für die Essgewohnheiten berechnen
      { 
         $essen_value=$essen_value+$value;
      }
   
      return $essen_value;
   }

   // allgemeine Fehlertextanzeige
   function rloulengo_error($text) 
   {
      echo ("<h2>$text</h2>");
      die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
   }     
}
?>