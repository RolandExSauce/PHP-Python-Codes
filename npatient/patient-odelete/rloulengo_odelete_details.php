<!DOCTYPE html>
<html><!-- odelete_details.php -->
<head>
   <title>Patienten-Daten löschen</title>
   <?php include "head.php"; ?>
</head>
<body>
   <?php include "header.php"; 
      //Klasse mit Methoden inkludieren
      include("../patient-myclass/rloulengo_myclass.php"); ?>
   <main>
      <?php
      $id_person=$_GET['id_person']; // GET-Information vom Link der vorigen Seite
      $patient=new RloulengoPatient(); // Objekt erzeugen (inkl. DB-Verbindung aufbauen)
      
      // alle Einträge für die Person mit der übergebenen Personen-ID in der Tabelle pa_besitzt löschen 
      $statement = "delete from rloulengo_besitzt where person_fid=$id_person"; // SQL-Befehl
      $patient->rloulengo_dbserver_query($statement);  // SQL-Abfrage durchführen
        
      // die Person mit der übergebenen Personen-ID in der Tabelle pa_person löschen 
      $statement = "delete from rloulengo_person where id_person=$id_person";
      $patient->rloulengo_dbserver_query($statement);  // SQL-Abfrage durchführen
      if ($patient->rloulengo_dbserver_rowCount() == 0) // prüfen ob ev. kein Datensatz gelöscht wurde
      {
         echo ("<h2>Der Patient ist nicht vorhanden.</h2>");
         die("<a href=\"javascript:history.back()\">Zurück</a>"); // Link für zurück zur letzten Seite
      }

      // alles in Ordnung
      echo ("<h2>Der Patient wurde erfolgreich gelöscht !</h2>");
      ?>      
   </main>
   <?php include "footer.php"; ?>
</body>
</html>  