<table border=1>
<tr>
<td><label for="vorname"> Vorname:</label></td>
<td><input type="text" id="vorname" name="vorname" size="8" maxlength="30" value="<?=$vorname?>"></td>
<td><label for="nachname"> Nachname:</label></td>
<td><input type="text" id="nachname" name="nachname" size="8" maxlength="30" value="<?=$nachname?>"></td>
</tr>

<tr>
<td colspan="2"><label for="svnr"> Sozialversicherungsnummer:</label></td>
<td><input type="text" id="svnr" name="svnr" size="8" maxlength="10" value="<?=$svnr?>"></td>
</tr>

<tr>
<td colspan="2"><label for="email"> E-Mail:</label></td>
<td><input type="text" id="email" name="email" size="8" maxlength="45" value="<?=$email?>"></td>
</tr>

<tr>
<td colspan="2"><label for="tel">Telefon:</label></td>
<td><input type="number" id="tel" name="tel" size="8" maxlength="10" value="<?=$tel?>"></td>
</tr>
<tr><td>
Geschlecht: <br>
<input type="radio" id="geschlecht1" name="geschlecht" value="w" checked="<?=$geschlecht_w?>">
<label for="html">weiblich</label><br>
<input type="radio" id="geschlecht2" name="geschlecht" value="m" checked="<?=$geschlecht_m?>">
<label for="html">männlich</label><br>
<input type="radio" id="geschlecht3" name="geschlecht" value="k" checked="<?=$geschlecht_k?>">
<label for="html">kein Eintrag</label>
</td><td colspan="3">
<label for="krankheit">Vorerkrankungen:</label><br>
<select name="krankheit[]" id="krankheit" size="3" multiple>
<?
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
<option value="1" selected="<?=$zv_ja?>">ja</option>
<option value="0" selected="<?=$zv_nein?>">nein</option>
</select>
</td><td>
<label for="gewicht"> Gewicht:</label></td><td>
<input type="text" id="gewicht" name="gewicht" size="8" maxlength="6" value="<?=$gewicht?>">
</td>
</tr><tr>
<td colspan="2"><label for="vorname"> Österreichischer Staatsbürger seit:</label></td>
<td><input type="text" id="staatsbuerger" name="staatsbuerger" size="8" maxlength="10" value="<?=$staatsbuerger?>"></td>
</tr>
<tr><td>
Essgewohnheiten:<br>
<input type="checkbox" id="essen1" name="essen[]" value="4" checked="<?=$essen_4?>">
<label for="essen1"> Frühstück</label><br>
<input type="checkbox" id="essen2" name="essen[]" value="2" checked="<?=$essen_2?>">
<label for="essen2"> Mittagessen</label><br>
<input type="checkbox" id="essen3" name="essen[]" value="1" checked="<?=$essen_1?>">
<label for="essen3"> Abendessen</label><br> 
</select></td>
<td colspan="3" align="right" valign="bottom">
<input type="submit" name="knopf" value="Hinzufügen">
</td></tr>
</table>