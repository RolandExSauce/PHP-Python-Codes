<!DOCTYPE html>
<html><!-- select_details.php -->
<head>
   <title>Patienten-Daten anzeigen</title>
   <?php include "head.php"; ?>
</head>
<body>
   <?php include "header.php"; ?>
   <main>
      <h2>Patienten-Daten anzeigen:</h2>
      <?php
      $id_person=$_GET['id_person']; // GET-Information vom Link der vorigen Seite
  
      // den gesamten Datensatz für die Person mit der übergebenen Personen-ID abfragen 
      $statement = "select * from rloulengo_person where id_person=$id_person";
      try // auf Fehler prüfen
      {
         $sql = $conn->prepare($statement);
         $sql->execute();
         // Ergebnis der SQL-Abfrage in assoziatives Array speichern
         $anz=$sql->rowCount(); // Anzahl der in der Tabelle gefundenen Datensätze
         if ($anz != 1) 
         {
            echo ("<h2>Die gewünschte Person wurde nicht eindeutig gefunden.</h2>");
            die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
         }   
         
         $person = $sql->fetchAll(PDO::FETCH_ASSOC); // assoziatives Array enthält genau einen Datensatz
      }
      catch (PDOException $e) 
      {  // detaillierte Fehlermeldung
         echo("<h2>Fehler bei der Datenbankabfrage</h2>in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
         die($e->getMessage()); 
      }
  
      // Vorbelegung der Eingabefelder mit den Werten aus der Tabelle 
      // keine Schleife erforderlich - die Werte sind im Zeilenindex 0 vorhanden
      $vorname=$person[0]["vorname"];
      $nachname=$person[0]["nachname"];
      $email=$person[0]["email"];
      $tel=$person[0]["tel"];
      
      $svnr=$person[0]["svnr"];
      $gewicht=$person[0]["gewicht"];
      $staatsbuerger=$person[0]["staatsbuerger"];
         
      // Wert aus der DB-Tabelle für den Radio-Button/Geschlecht anzeigen
      $geschlecht=$person[0]["geschlecht"]; // Wert aus dem Array auslesen
      $geschlecht_w=$geschlecht_m=$geschlecht_k=""; // Initialisierung der Optionen
      // Wert aus der DB-Tabelle setzen
      switch($geschlecht)
      {
         case "w": 
            $geschlecht_w="checked";
         break;
         case "m":
            $geschlecht_m="checked"; 
         break;          
         case "k":
            $geschlecht_k="checked";
         break;       
      }
      
      // Wert aus der DB-Tabelle für die Einfachauswahlliste/Zusatzversicherung anzeigen
      $zv=$person[0]["zv"]; // Wert aus dem Array auslesen
      $zv_ja=$zv_nein=""; // Initialisierung der Optionen
      // Wert aus der DB-Tabelle setzen
      if ($zv==1) 
         $zv_ja="selected";
      else 
         $zv_nein="selected";

      // Wert aus der DB-Tabelle für die Checkbox/Essgewohnheiten anzeigen
      $essen=$person[0]["essen"]; // Wert aus dem Array auslesen
      // Vorbelegung der Werte für Checkbox/Essgewohnheiten
      $essen_4=$essen_2=$essen_1="";// Initialisierung der Werte
      // Werte aus der DB-Tabelle setzen
      switch($essen)
      {
          case 1:
             $essen_1="checked";
          break;
          case 2:
             $essen_2="checked";
          break;
          case 3:
             $essen_2="checked";
             $essen_1="checked";
          break;          
          case 4:
             $essen_4="checked";
          break;          
          case 5:
             $essen_4="checked";
             $essen_1="checked";
          break;          
          case 6:
             $essen_4="checked";
             $essen_2="checked";
          break;          
          case 7:
             $essen_4="checked";
             $essen_2="checked";
             $essen_1="checked";
          break;
      }
      
      // Erkrankungen des Benutzers ermitteln und in ein Array speichern (Abfrage über zwei Tabellen mit LEFT JOIN)
      $statement="SELECT * from rloulengo_krankheit LEFT JOIN rloulengo_besitzt ON id_krankheit=krankheit_fid WHERE person_fid=$id_person ORDER BY bezeichnung";
      
      try // auf Fehler prüfen 
      {
         $sql = $conn->prepare($statement);
         $sql->execute();
         // Ergebnis der SQL-Abfrage in assoziatives Array speichern
         $krankheiten_liste = $sql->fetchAll(PDO::FETCH_ASSOC);
      }
      catch (PDOException $e) 
      {  // detaillierte Fehlermeldung
         echo ("<h2>Fehler bei der Datenbankabfrage</h2>in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
         die($e->getMessage()); 
      }
       
      // GUI für die Anzeige inkludieren      
      require "rloulengo_sgui.php" 
      ?>      
   </main>
   <?php include "footer.php"; ?>
</body>
</html>  