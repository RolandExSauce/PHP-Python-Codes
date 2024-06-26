<table border=1>
<tr>
<td><label for="vorname"> Vorname:</label></td>
<td><input type="text" id="vorname" name="vorname" size="8" maxlength="30" value="<?php echo $vorname; ?>"></td>
<td><label for="nachname"> Nachname:</label></td>
<td><input type="text" id="nachname" name="nachname" size="8" maxlength="30" value="<?php echo $nachname; ?>"></td>
</tr>


<tr>
<td colspan="2"><label for="svnr"> Sozialversicherungsnummer:</label></td>
<td><input type="text" id="svnr" name="svnr" size="15" maxlength="10" value="<?php echo $svnr; ?>">
</tr>
<tr>


<tr>
<td colspan="2"><label for="email"> email:</label>
<td><input type="text" id="email" name="email" size="15" maxlength="50" value="<?php echo $svnr; ?>"></td>
</tr>
<tr>


<tr>
<td colspan="2"><label for="tel"> Telefon:</label></td>
<td><input type="text" id="tel" name="tel" size="15" maxlength="10" value="<?php echo $svnr; ?>"></td>
</tr>
<tr><td>



Geschlecht: <br>
<input type="radio" id="geschlecht1" name="geschlecht" value="w" <?php echo $geschlecht_w; ?>>
<label for="html">weiblich</label><br>
<input type="radio" id="geschlecht2" name="geschlecht" value="m" <?php echo $geschlecht_m; ?>>
<label for="html">männlich</label><br>
<input type="radio" id="geschlecht3" name="geschlecht" value="k" <?php echo $geschlecht_k; ?>>
<label for="html">kein Eintrag</label>
</td><td colspan="3">
<label for="krankheit">Vorerkrankungen:</label><br>
<select name="krankheit[]" id="krankheit" size="3" multiple>
<?php
   // alle Krankheite (= alle Datensätze) in Select-Option einbauen
   foreach ($krankheiten_liste as $row => $krankheit) 
   { 
      $key=$krankheit['id_krankheit'];
      $value=$krankheit['bezeichnung'];
      echo ("<option value=$key>$value</option><br>");
    }   
 ?>
</select>
</td></tr>
<tr><td>
<label for="zv">Zusatzversicherung:</label></td><td>
<select name="zv" id="zv">
<option value="1" <?php echo $zv_ja; ?>>ja</option>
<option value="0" <?php echo $zv_nein; ?>>nein</option>
</select>
</td><td>
<label for="gewicht"> Gewicht:</label></td><td>
<input type="text" id="gewicht" name="gewicht" size="8" maxlength="6" value="<?php echo $gewicht; ?>">
</td>
</tr><tr>
<td colspan="2"><label for="vorname"> Österreichischer Staatsbürger seit:</label></td>
<td><input type="text" id="staatsbuerger" name="staatsbuerger" size="8" maxlength="10" value="<?php echo $staatsbuerger; ?>"></td>
</tr>
<tr><td>
Essgewohnheiten:<br>
<input type="checkbox" id="essen1" name="essen[]" value="4" <?php echo $essen_4; ?>>
<label for="essen1"> Frühstück</label><br>
<input type="checkbox" id="essen2" name="essen[]" value="2" <?php echo $essen_2; ?>>
<label for="essen2"> Mittagessen</label><br>
<input type="checkbox" id="essen3" name="essen[]" value="1" <?php echo $essen_1; ?>>
<label for="essen3"> Abendessen</label><br> 
</select></td>
<td colspan="3" align="right" valign="bottom">
</td></tr>
</table>