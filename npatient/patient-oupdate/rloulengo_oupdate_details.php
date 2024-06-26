<!DOCTYPE html>
<html><!-- oupdate_details.php -->
<head>
   <title>Patienten-Daten erfassen</title>
   <?php include "head.php"; ?>
</head>
<body>
   <?php include "header.php"; 
     //Klasse mit Methoden inkludieren
   include("../patient-myclass/rloulengo_myclass.php"); ?>
   <main>
      <?php
      // Objekt erzeugen (inkl. DB-Verbindung aufbauen)
      $patient=new RloulengoPatient();
            
      if (isset($_POST['knopf'])) // alle Benutzereingaben in der Datenbank speichern
      {
         $id_person=$_GET['id_person']; // GET-Information vom letzten Formular 

         // Prüfung der Inhalte in den Eingabefeldern
         $patient->rloulengo_check_regexp("Vorname",$re_name,$vorname=$_POST['vorname']); // formale Prüfung Vorname
         $patient->rloulengo_check_regexp("Nachname",$re_name,$nachname=$_POST['nachname']); // formale Prüfung Nachname
         $patient->rloulengo_check_regexp("Sozialversicherungsnummer",$re_svnr,$svnr=$_POST['svnr']); // formale Prüfung SVNR
         
         $gewicht=str_replace(",",".",$_POST['gewicht']); // Beistrich durch Punkt ersetzen    
         $patient->rloulengo_check_regexp("Gewicht",$re_gewicht,$gewicht); // formale Prüfung Gewicht
         if ($gewicht > 999.99) $patient->rloulengo_gui_error("Gewicht"); // inhaltliche Prüfung Gewicht
         
		 // formale Prüfung Staatsbuerger
         $patient->rloulengo_check_regexp("Staatsbürger",$re_date,$staatsbuerger=$_POST['staatsbuerger']); 
         $ar_date_buerger=explode("-",$staatsbuerger); // Datum in Jahr, Monat und Tag zerlegen und in Array speichern
         // inhaltliche Prüfung Datum Staatsbürger - ob das Datum tatsächlich existiert - der Effekt der Schaltjahre uvm. 
         if (!checkdate($ar_date_buerger[1],$ar_date_buerger[2],$ar_date_buerger[0])) rloulengo_gui_error("Staatsbürger");
         
         $geschlecht=$_POST['geschlecht']; // Geschlecht
         $zv=$_POST['zv'];  // Zusatzversicherung
     
         // die ganze Zahl zwischen 0 bis 7 für die Essgewohnheiten ermitteln
         if (isset($_POST['essen'])) $essen_value=$patient->rloulengo_calc_foodnumber($_POST['essen']);
         else $essen_value=0;
 
         // SQL-Abfrage für Tabelle rloulengo_person festlegen und SQL-Abfrage durchführen
         $statement="update rloulengo_person set vorname='$vorname',nachname='$nachname',svnr='$svnr',geschlecht='$geschlecht',";
         $statement=$statement."zv='$zv',gewicht='$gewicht',staatsbuerger='$staatsbuerger',essen='$essen_value'";
         $statement=$statement."where id_person=$id_person";
         $patient->rloulengo_dbserver_query($statement);  // SQL-Abfrage durchführen
 
         // alle vorhandenen Einträge für diese Person in der Tabelle rloulengo_besitzt löschen
         $person_fid=$id_person; // explizit auf Grund der Tabellenrelationen 
         $statement="delete from rloulengo_besitzt where person_fid = $person_fid";
         $patient->rloulengo_dbserver_query($statement);  // SQL-Abfrage durchführen

         if (isset($_POST['krankheit'])) // wenn zumindest eine Select Option angewählt wurde
         {
            $krankheit=$_POST['krankheit'];
        
            // jede Krankheit der Person als einzelnen Datensatz in die Tabelle rloulengo_besitzt eintragen
            foreach ($krankheit as $row => $krankheit_fid)
            {
               $statement="insert into rloulengo_besitzt (person_fid,krankheit_fid) values ('$id_person','$krankheit_fid');";
               $patient->rloulengo_dbserver_query($statement);  // SQL-Abfrage durchführen
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
         $patient->rloulengo_dbserver_query($statement);  // SQL-Abfrage durchführen
         $anz=$patient->rloulengo_dbserver_rowCount(); // Anzahl der in der Tabelle gefundenen Datensätze
         if ($anz != 1) 
         {
            echo ("<h2>Die gewünschte Person wurde nicht eindeutig gefunden.</h2>");
            die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
         }   
         
         // Ergebnis der SQL-Abfrage in assoziatives Array speichern
         $person = $patient->rloulengo_dbserver_fetchAll(); // assoziatives Array enthält genau einen Datensatz
   
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
         
         // die Erkrankungen der Person ermitteln und in ein Array speichern (Abfrage über zwei Tabellen mit LEFT JOIN)
         $statement="SELECT * from rloulengo_krankheit LEFT JOIN rloulengo_besitzt ON ";
         $statement=$statement."id_krankheit=krankheit_fid WHERE person_fid=$id_person ORDER BY bezeichnung";
         $patient->rloulengo_dbserver_query($statement); // SQL-Abfrage durchführen
         // Ergebnis der SQL-Abfrage in assoziatives Array speichern
         $krankheiten_der_person_liste = $patient->rloulengo_dbserver_fetchAll();

         // alle in Tabelle rloulengo_krankheit eingetragenen Krankheiten ermitteln
         $statement="select * from rloulengo_krankheit order by bezeichnung";
         $patient->rloulengo_dbserver_query($statement); // SQL-Abfrage durchführen
         // Ergebnis der SQL-Abfrage in assoziatives Array speichern
         $krankheiten_liste = $patient->rloulengo_dbserver_fetchAll();
      
         echo "<h2>Patienten-Daten ändern:</h2>";
         echo "<form action='rloulengo_oupdate_details.php?id_person=$id_person' method='post'>";
         require "rloulengo_ugui.php"; // GUI für die Anzeige inkludieren
         echo "<input type='submit' name='knopf' value='Ändern'>";
         echo "</form>";
      }
      ?>
   </main>
      <?php include "footer.php"; ?>
   </body>
</html>