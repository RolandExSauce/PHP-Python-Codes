
      <?php
         include "../patient-myclass/rloulengo_myclass.php" 
         include "../data.php"
       
      // Objekt erzeugen (inkl. DB-Verbindung aufbauen)
      $exportTable=new rloulengoPatient();



    
        //export.php  
    if(isset($_POST["export"]))  
    {  
        $connect = mysqli_connect($servername, $dbname=$username, $password,);  

        header('Content-Type: text/csv; charset=utf-8');  
        header('Content-Disposition: attachment; filename=rloulengo_person.csv');  
        $output = fopen("php://output", "w");  
        fputcsv($output, array('id_person', 'svnr', 'vorname', 'nachname', 'tel', 'email', 'geschlecht', 'gewicht', 'staatsbuerger', 'zv',	'essen'
        ));  
        $query = "SELECT * from rloulengo_person ORDER BY id DESC";  
        $result = mysqli_query($connect, $query);  
        while($row = mysqli_fetch_assoc($result))  
        {  
            fputcsv($output, $row);  
        }  
        fclose($output);  
    }  


?>

