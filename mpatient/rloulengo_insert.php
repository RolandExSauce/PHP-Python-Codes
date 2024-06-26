<!DOCTYPE html>
<html><!-- insert.php -->
<head>
   <title>Patienten-Daten erfassen</title>
   <?php include "head.php"; ?>
</head>
<body>
   <?php include "header.php"; ?>
   <main>
      <?php
      if (isset($_POST['knopf'])) // alle Benutzereingaben in Datenbank speichern
      {
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
         


         $email=$_POST['email'];
         if (!preg_match($re_email,$email)) // formale Prüfung email
         {
            echo("<h2>Ungültige Eingabe für die email.</h2>");
            die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
         }

         
         $tel=$_POST['tel'];
         if (!preg_match($re_tel,$tel)) // formale Prüfung Telefonnummer
         {
            echo("<h2>Ungültige Eingabe für die Telefonnummer.</h2>");
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
         
         $geschlecht=$_POST['geschlecht'];
         $zv=$_POST['zv'];
     
         if (isset($_POST['essen'])) // wenn zuminest eine Checkbox angewählt wurde
         {
            $essen=$_POST['essen'];  // $essen ist ein eindimensionales Array         
            $essen_value=0;          // Vorbelegung für die Summenbildung
            
            foreach ($essen as $key => $value) // Wert für Essgewohnheiten berechnen
            { 
               $essen_value=$essen_value+$value;
            }
         }

         //prüfen ob die aktuelle Sozialversicherungsnummer bereits in der DB existiert
         $statement="select svnr from rloulengo_person where svnr=$svnr";
         
         try // auf Fehler prüfen
         {
            $sql = $conn->prepare($statement);
            $sql->execute();
            $anz_svnr=$sql->rowCount(); // Anzahl der in der Tabelle gefundenen Sozialversicherungsnummern
         }
         catch (PDOException $e) 
         {  // detaillierte Fehlermeldung
            echo("<h2>Fehler bei der Datenbankabfrage</h2>in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
            die($e->getMessage()); 
         }
   
         if ($anz_svnr != 0) // wenn in der Datenbank dieselbe Sozialversicherungsnummer gefunden wurde
         {
            echo ("<h2>Patient mit derselben Sozialversicherungsnummer bereits vorhanden.</h2>");
            die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
         }

         // SQL-Abfrage für Tabelle pa_person festlegen und SQL-Abfrage durchführen
         $statement="insert into rloulengo_person (vorname,nachname, email, tel, svnr,geschlecht,zv,gewicht,staatsbuerger,essen) 
            values ('$vorname','$nachname','$email','$tel','$svnr','$geschlecht','$zv','$gewicht','$staatsbuerger','$essen_value');";
            
         try // auf Fehler prüfen
         {
            $sql = $conn->prepare($statement);
            $sql->execute();
            // id_person des zuvor eingetragenen Datensatz in pa_person ermitteln => für $person_fid in pa_besitzt
            $person_fid=$id_person = $conn->lastInsertId();
         }
         catch (PDOException $e) 
         {  // detaillierte Fehlermeldung
            echo("<h2>Fehler bei der Datenbankabfrage</h2>in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
            die($e->getMessage()); 
         }  
 
         if (isset($_POST['krankheit'])) // wenn zumindest eine Select Option angewählt wurde
         {
            $krankheit=$_POST['krankheit'];
        
            // jede Krankheit als einzelnen Datensatz in die Tabelle pa_besitzt eintragen
            foreach ($krankheit as $row => $krankheit_fid)
            {
               $statement="insert into rloulengo_besitzt (person_fid,krankheit_fid) values ('$person_fid','$krankheit_fid');";
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
         die("<h2>Der Patient wurde erfolgreich hinzugefügt !</h2>");
      }
      else
      {
         // Vorbelegung der Eingabefelder
         $vorname=$nachname=$svnr=$email=$tel=$gewicht=$staatsbuerger="";
         // Vorbelegung der Werte für den Radio-Button/Geschlecht
         $geschlecht_k="checked"; $geschlecht_w=$geschlecht_m=""; 
         // Vorbelegung der Werte für Einfach-Auswahlliste/Zusatzversicherung
         $zv_ja=""; $zv_nein="selected"; 
         // Vorbelegung der Werte für Checkbox/Essgewohnheiten
         $essen_4=$essen_2=$essen_1="checked";
         // Mehrfachauswahlliste Krankheit für die Anzeige aus der Datenbank mit Inhalt vorbelegen
         $statement="select * from rloulengo_krankheit order by bezeichnung";
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
       
         // Ergebnis der SQL-Abfrage in Assoziatives Array speichern
         $krankheiten_liste = $sql->fetchAll(PDO::FETCH_ASSOC);        
      }
      ?>

      <h2>Patienten-Daten erfassen:</h2>
      <form action="rloulengo_insert.php" method=post>
      <?php require "rloulengo_gui.php" ?>
      </form>
   </main>
   <?php include "footer.php"; ?>




   
</body>
</html>