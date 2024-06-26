<!DOCTYPE html>
<html><!-- update_details.php -->
<head>
   <title>Patienten-Daten erfassen</title>
   <?php include "head.php"; ?>
</head>
<body>
   <?php include "header.php"; ?>
   <main>
      <?php
      if (isset($_POST['knopf'])) // alle Benutzereingaben in der Datenbank speichern
      {
         $id_person=$_GET['id_person']; // GET-Information vom letzten Formular 

         $vorname=$_POST['vorname'];
         if (!preg_match($re_name,$vorname)) // formale Prüfung Vornamen
         {
            echo("<h2>Ungültige Eingabe für den Vornamen.</h2>");
            die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
         }
         
         $nachname=$_POST['nachname'];
         if (!preg_match($re_name,$nachname)) // formale Prüfung Nachnamen
         {
            echo("<h2>Ungültige Eingabe für den Nachnamen.</h2>");
            die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
         }
         
         $svnr=$_POST['svnr'];
         if (!preg_match($re_svnr,$svnr)) // formale Prüfung Sozialversicherungsnummer
         {
            echo("<h2>Ungültige Eingabe für die Sozialversicherungsnummer.</h2>");
            die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
         } 
         
         $gewicht=str_replace(",",".",$_POST['gewicht']); // Beistrich durch Punkt ersetzen    
         if (!preg_match($re_gewicht,$gewicht) || $gewicht > 999.99) // Prüfung Gewicht
         {
            echo("<h2>Ungültige Eingabe für das Gewicht.</h2>");
            die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
         } 
         
         $staatsbuerger=$_POST['staatsbuerger'];         
         if (!preg_match($re_date,$staatsbuerger)) // formale Prüfung Datum     
         {
            echo("<h2>Ungültige Eingabe für Datum (YYY-MM-DD).</h2>");
            die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
         } 
         
         $ar_date_buerger=explode("-",$staatsbuerger); // Datum in Jahr, Monat und Tag zerlegen und in Array speichern
         if (!checkdate($ar_date_buerger[1],$ar_date_buerger[2],$ar_date_buerger[0])) // inhaltliche Prüfung Datum
         {
            echo("<h2>Ungültige Eingabe für Datum     .</h2>");
            die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
         }
         
         $geschlecht=$_POST['geschlecht']; // Geschlecht
         $zv=$_POST['zv'];  // Zusatzversicherung
     
         $essen_value=0;          // Vorbelegung für die Summenbildung
         if (isset($_POST['essen'])) // wenn zuminest eine Checkbox angewählt wurde
         {
            $essen=$_POST['essen'];  // $essen ist ein eindimensionales Array         
            foreach ($essen as $key => $value) // Gesamtwert für die Essgewohnheiten berechnen
            { 
               $essen_value=$essen_value+$value;
            }
         }
           
         try // auf Fehler prüfen
         {
	        // SQL-Abfrage für Tabelle pa_person festlegen und SQL-Abfrage durchführen
            $statement="update rloulengo_person set vorname='$vorname',nachname='$nachname',svnr='$svnr',geschlecht='$geschlecht',";
            $statement=$statement."zv='$zv',gewicht='$gewicht',staatsbuerger='$staatsbuerger',essen='$essen_value'";
            $statement=$statement."where id_person=$id_person";
            $sql = $conn->prepare($statement);
            $sql->execute();
 
            // alle vorhandenen Einträge für diese Person in der Tabelle pa_besitzt löschen
            $person_fid=$id_person; // explizit auf Grund der Tabellenrelationen 
            $statement="delete from rloulengo_besitzt where person_fid = $person_fid";
            $sql = $conn->prepare($statement);
            $sql->execute();
         }
         catch (PDOException $e) 
         {  // detaillierte Fehlermeldung
            echo ("<h2>Fehler bei der Datenbankabfrage</h2>in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
            die($e->getMessage()); 
         }
 
         if (isset($_POST['krankheit'])) // wenn zumindest eine Select Option angewählt wurde
         {
            $krankheit=$_POST['krankheit'];
        
            // jede Krankheit der Person als einzelnen Datensatz in die Tabelle pa_besitzt eintragen
            foreach ($krankheit as $row => $krankheit_fid)
            {
               $statement="insert into rloulengo_besitzt (person_fid,krankheit_fid) values ('$id_person','$krankheit_fid');";
               try // auf Fehler prüfen 
               {
                  $sql = $conn->prepare($statement);
                  $sql->execute();
               }
               catch (PDOException $e) 
               {  // detaillierte Fehlermeldung
                  echo ("<h2>Fehler bei der Datenbankabfrage</h2>in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
                  die($e->getMessage()); 
               }
            }
         }
         
         // alles in Ordnung
         die("<h2>Der Patient wurde erfolgreich geändert !</h2>");
      }
      else // die vorhandenen Werte aus der Datenbank in der GUI anzeigen
      {
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
      
         try // auf Fehler prüfen 
         {
			// die Erkrankungen der Person ermitteln und in ein Array speichern (Abfrage über zwei Tabellen mit LEFT JOIN)
            $statement="SELECT * from rloulengo_krankheit LEFT JOIN rloulengo_besitzt ON ";
			$statement=$statement."id_krankheit=krankheit_fid WHERE person_fid=$id_person ORDER BY bezeichnung";
            $sql = $conn->prepare($statement);
            $sql->execute();
            // Ergebnis der SQL-Abfrage in assoziatives Array speichern
            $krankheiten_der_person_liste = $sql->fetchAll(PDO::FETCH_ASSOC);

            // alle in Tabelle pa_krankheit eingetragenen Krankheiten ermitteln
            $statement="select * from rloulengo_krankheit order by bezeichnung";
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
      
         echo "<h2>Patienten-Daten ändern:</h2>";
         echo "<form action='rloulengo_update_details.php?id_person=$id_person' method='post'>";
         require "rloulengo_ugui.php"; // GUI für die Anzeige inkludieren
         echo "<input type='submit' name='knopf' value='Ändern'>";
         echo "</form>";
      }
      ?>
   </main>
      <?php include "footer.php"; ?>
   </body>
</html>