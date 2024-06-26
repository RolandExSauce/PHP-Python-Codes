<!DOCTYPE html>
<html><!-- oinsert.php -->
<head>
   <title>Patienten-Daten erfassen</title>
   <?php include "head.php"; ?>
</head>
<body>
   <?php include "header.php"; 
   //Klasse mit Methoden inkludieren
   include "../patient-myclass/rloulengo_myclass.php" ?>
   <main>
      <?php
      // Objekt erzeugen (inkl. DB-Verbindung aufbauen)
      $patient=new rloulengoPatient();
      
      if (isset($_POST['knopf'])) // alle Benutzereingaben in Datenbank speichern
      {
         // Prüfung der Inhalte in den Eingabefeldern
         $patient->rloulengo_check_regexp("norname",$re_name,$vorname=$_POST['vorname']); // formale Prüfung Vorname
         $patient->rloulengo_check_regexp("nachname",$re_name,$nachname=$_POST['nachname']); // formale Prüfung Nachname
         $patient->rloulengo_check_regexp("sozialversicherungsnummer",$re_svnr,$svnr=$_POST['svnr']); // formale Prüfung SVNR
         $patient->rloulengo_check_regexp("email",$re_email,$email=$_POST['email']); 
		 $patient->rloulengo_check_regexp("tel",$re_tel,$tel=$_POST['tel']); 
		 
         $gewicht=str_replace(",",".",$_POST['gewicht']); // Beistrich durch Punkt ersetzen    
         $patient->rloulengo_check_regexp("Gewicht",$re_gewicht,$gewicht); // formale Prüfung Gewicht
         if ($gewicht > 999.99) $patient->rloulengo_gui_error("Gewicht"); // inhaltliche Prüfung Gewicht
         
         // formale Prüfung Staatsbuerger
         $patient->rloulengo_check_regexp("Staatsbürger",$re_date,$staatsbuerger=$_POST['staatsbuerger']);
         $ar_date_buerger=explode("-",$staatsbuerger); // Datum in Jahr, Monat und Tag zerlegen und in Array speichern
         // inhaltliche Prüfung Datum Staatsbürger - ob das Datum tatsächlich existiert - der Effekt der Schaltjahre uvm. 
         if (!checkdate($ar_date_buerger[1],$ar_date_buerger[2],$ar_date_buerger[0])) $patient->my_gui_error("Staatsbürger");
         
         $geschlecht=$_POST['geschlecht']; // Geschlecht
         $zv=$_POST['zv'];  // Zusatzversicherung
     
         // die ganze Zahl zwischen 0 bis 7 für die Essgewohnheiten ermitteln
         if (isset($_POST['essen'])) 
            $essen_value=$patient->rloulengo_calc_foodnumber($_POST['essen']);
         else 
            $essen_value=0;

         //prüfen ob die aktuelle Sozialversicherungsnummer bereits in der DB-Tabelle vorhanden ist
         $statement="select svnr from rloulengo_person where svnr=$svnr";
         $patient->rloulengo_dbserver_query($statement);  // SQL-Abfrage durchführen
         // Anzahl der in der Tabelle vorhandenen Sozialversicherungsnummern ermitteln
         $anz_svnr=$patient->rloulengo_dbserver_rowCount(); 
         // wenn in der Datenbank dieselbe Sozialversicherungsnummer gefunden wurde
         if ($anz_svnr != 0) $patient->rloulengo_error("Patient mit derselben Sozialversicherungsnummer bereits vorhanden.");
 
         // SQL-Abfrage für Tabelle pa_person festlegen und SQL-Insert durchführen
         $statement="insert into rloulengo_person (vorname,nachname,svnr,email,tel,geschlecht,zv,gewicht,staatsbuerger,essen) 
            values ('$vorname','$nachname','$svnr','$email','$tel','$geschlecht','$zv','$gewicht','$staatsbuerger','$essen_value');";
            
         $patient->rloulengo_dbserver_query($statement);  // SQL-Abfrage durchführen
         // id_person des zuvor eingetragenen Datensatzes in pa_person ermitteln => für $person_fid in pa_besitzt
         $person_fid=$id_person = $patient->rloulengo_dbserver_lastInsertId();

         // wenn zumindest eine Select Option angewählt wurde --> alle Krankheiten in die Tabelle speichern
         if (isset($_POST['krankheit'])) $patient->rloulengo_dbserver_insert_diseases($person_fid,$_POST['krankheit']); 

         // alles in Ordnung
         die("<h2>Der Patient wurde erfolgreich hinzugefügt !</h2>");
      }
      else
      {
         // Vorbelegung der Eingabefelder
         $vorname=$nachname=$svnr=$email=$telnummer=$gewicht=$staatsbuerger="";
         // Vorbelegung der Werte für den Radio-Button/Geschlecht
         $geschlecht_w=""; $geschlecht_m=""; $geschlecht_k="checked"; 
         // Vorbelegung der Werte für Einfach-Auswahlliste/Zusatzversicherung
         $zv_ja=""; $zv_nein="selected"; 
         // Vorbelegung der Werte für Checkbox/Essgewohnheiten
         $essen_4=$essen_2=$essen_1="checked";
         
         // Mehrfachauswahlliste Krankheit für die Anzeige aus der Datenbank mit Inhalt vorbelegen
         $statement="select * from rloulengo_krankheit order by bezeichnung";
         $patient->rloulengo_dbserver_query($statement);  // SQL-Abfrage durchführen
         // Ergebnis der SQL-Abfrage in assoziatives Array speichern
         $krankheiten_liste = $patient->rloulengo_dbserver_fetchAll();        
      }
      ?>
      <h2>Patienten-Daten erfassen:</h2>
      <form action="rloulengo_oinsert.php" method=post>
      <?php require "rloulengo_gui.php" ?>
      <input type="submit" name="knopf" value="Hinzufügen">
      </form>
   </main>
   <?php include "footer.php"; ?>
</body>
</html>