
<html><!-- select_details.php -->
<head>
  
   <?php include "head.php"; ?>
</head>
<body>
   <?php include "header.php"; ?>
   <main>
      
      <?php
      $id_person=$_GET['id_person'];
       // GET-Information vom Link der vorigen Seite
	 
		$statement= "delete from rloulengo_besitzt where person_fid='$id_person'";
		$sql = $conn->prepare($statement);
        $sql->execute();
		$statement2="delete from rloulengo_person where id_person='$id_person'";
		$sql2 = $conn->prepare($statement2);
        $sql2->execute();
		// SQL-Abfrage durchführen
		die("<h2>Der Patient wurde gelöscht !</h2>");
      ?>      
   </main>
   <?php include "footer.php"; ?>
</body>
</html>