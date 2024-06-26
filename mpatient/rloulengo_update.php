<!DOCTYPE html>
<html><!-- update.php -->
<head>
   <title>Patienten-Daten ändern</title>
   <?php include "head.php"; ?>
</head>
<body>
   <?php include "header.php"; ?>
   <main>
      <h2>Patienten-Daten ändern:</h2>
      <?php
      $statement = "select id_person,vorname,nachname,svnr from rloulengo_person;";
      try // auf Fehler prüfen
      {
         $sql = $conn->prepare($statement);
         $sql->execute();
         // Ergebnis der SQL-Abfrage in assoziatives Array speichern
         $personen_liste = $sql->fetchAll(PDO::FETCH_ASSOC);
      }
      catch (PDOException $e) 
      {  // detaillierte Fehlermeldung
         echo("<h2>Fehler bei der Datenbankabfrage</h2>in Datei ".__FILE__." in Zeile ".__LINE__.":<br><br>");
         die($e->getMessage()); 
      }
          
      // für alle Personen den Vorname, Nachname und die SVNR tabellarisch anzeigen
      echo "<table border=1>";
      echo "<tr><th>Vorname</th><th>Nachname</th><th>SV-Nummer</th><th></th></tr>";
      foreach ($personen_liste as $key => $value) 
      { 
         $id_person=$value['id_person'];
         $vorname=$value['vorname'];
         $nachname=$value['nachname'];
         $svnr=$value['svnr'];
         echo "<tr><td>$vorname</td><td>$nachname</td><td>$svnr</td><td>";
         // ein Link und Button mit dem GET-Parameter für die Personen-Id definieren
         echo "<Button><a href='rloulengo_update_details.php?id_person=$id_person'>Ändern</a></Button>";
         echo "</td></tr>";
      }   
      echo "</table>";         
      ?>
   </main>
   <?php include "footer.php"; ?>
</body>
</html>      
      