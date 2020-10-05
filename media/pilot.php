<?php
$db = new mysqli("185.248.140.14","Test","test","mysqlcshap");
if($db->connect_error){
    echo $db->connect_error;
}

?>

<html>

<table>
<tr>
<th>id</th>
<th>Auftragsnummer</th>
<th>Stichwort</th>
<th>Einsatzinformation</th>
<th>Objekt</th>
<th>Straße</th>
<th>HNR</th>
<th>Ort</th>
<th>Fahrzeug</th>
<th>viewed</th>
</tr>

<tr>
<td id="id">/</td>
<td id="AID">/</td>
<td id="SW">/</td>
<td id="EI">/</td>
<td id="OT">/</td>
<td id="STR">/</td>
<td id="HNR">/</td>
<td id="ORT">/</td>
<td id="FZG">/</td>
<td id="VWD">/</td>
</tr>
</table>
<button onclick="schreiben()">test</button>
 <iframe src="https://www.google.de/" title="W3Schools Free Online Web Tutorials"></iframe> 
<script language="javascript" type="text/javascript" src="./subpages/JS/pilot.js"></script>
</html>
