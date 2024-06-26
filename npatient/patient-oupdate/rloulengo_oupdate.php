<!DOCTYPE html>
<html><!-- oupdate.php -->
<head>
   <title>Patienten-Daten ändern</title>
   <?php include "head.php"; ?>
</head>
<body>
   <?php include "header.php"; 
      //Klasse mit Methoden inkludieren
      include("../patient-myclass/rloulengo_myclass.php"); ?>
   <main>
      <h2>Patienten-Daten ändern:</h2>
      <?php
      $patient=new RloulengoPatient(); // Objekt erzeugen (inkl. DB-Verbindung aufbauen)
      $statement = "select id_person,vorname,nachname,svnr from rloulengo_person;"; // SQL-Befehl
      $patient->rloulengo_dbserver_query($statement);  // SQL-Abfrage durchführen
      // Ergebnis der SQL-Abfrage in assoziatives Array speichern
      $personen_liste = $patient->rloulengo_dbserver_fetchAll();
         
      // für alle Personen den Vorname, Nachname und die SVNR tabellarisch anzeigen
      echo "<table border=1>";
      echo "<tr><th>Vorname</th><th>Nachname</th><th>SV-Nummer</th><th></th></tr>";
      foreach ($personen_liste as $value) 
      { 
         $id_person=$value['id_person'];
         $vorname=$value['vorname'];
         $nachname=$value['nachname'];
         $svnr=$value['svnr'];
         echo "<tr><td>$vorname</td><td>$nachname</td><td>$svnr</td><td>";
         // ein Link und Button mit dem GET-Parameter für die Personen-Id definieren
         echo "<Button><a href='rloulengo_oupdate_details.php?id_person=$id_person'>Ändern</a></Button>";
         echo "</td></tr>";
      }   
      echo "</table>";  
      ?>
   </main>
   <?php include "footer.php"; ?>
</body>
</html>