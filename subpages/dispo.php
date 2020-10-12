<link rel="stylesheet" href="/subpages/css/dispo.css">
<script src="/subpages/JS/notify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha512-v8ng/uGxkge3d1IJuEo6dJP8JViyvms0cly9pnbfRxT6/31c3dRWxIiwGnMSWwZjHKOuY3EVmijs7k1jz/9bLA==" crossorigin="anonymous"></script>

<table id="loggedinPilots">
    <tr>
        <th>Name</td>
        <th>Station</td>
    </tr>
</table>
<select name="activeFahrzeug" id="selectFahrzeuge">
    <?php
        $stmt = $db->query("SELECT * FROM Fahrzeugliste ORDER BY id ASC");
        ?>
        <option>Bitte Wähle dein Fahrzeug aus der Liste aus</option>
        <?php
        while($Fahrzeuge = $stmt->fetch_object()) { ?>
        <option><?php echo $Fahrzeuge->Fahrzeuge ?></option>
        <?php } ?>
    ?>
    </select><br>
<input type="text" placeholder="id" id="id"><br>
<input type="text" placeholder="Auftragsnummer" id="Auftragsnummer"><br>
<input maxlength="7" type="text" placeholder="Objekt" id="Objekt"><br>
<input maxlength="2" type="text" placeholder="Etage" id="Etage"><br>
<input maxlength="20" type="text" placeholder="Straße" id="Straße"><br>
<input maxlength="3" type="text" placeholder="HNR" id="HNR"><br>
<input maxlength="10" type="text" placeholder="Ort" id="Ort"><br>
<input maxlength="20" type="text" placeholder="Ortsteil" id="Ortsteil"><br>
<input maxlength="22" type="text" placeholder="Stichwort" id="Stichwort"><br>
<input maxlength="22" type="text" placeholder="Einsatzinformation" id="Einsatzinformation"><br>
<button id="submit">Senden</button>
<script>
const loggedinPilots = document.getElementById("loggedinPilots")
    var socket = io.connect("https://websocket.pxlloewe.de", {secure: true});
const submit = document.getElementById("submit");
    socket.emit("reqData", "Dispo")

    socket.on("sendData", (data) =>{
        console.log(data);
        var Pilots = data.piloten
        loggedinPilots.innerHTML = "<tr><td>Name</td><td>DiscordID</td><td>DiscordAlarmierung</td><td>Station</td><td>popup</td></tr>";
        for(var i = 0; i < Pilots.length; i ++){
            loggedinPilots.innerHTML += '<tr><td>' + Pilots[i].realName + "</td><td>" + Pilots[i].discordId + "</td><td>" + Pilots[i].discordAlarmierung + "</td><td>" + Pilots[i].stationName + "</td><td>" + Pilots[i].popup +"</td></tr>"
        }
        
    })
    socket.on("disconnect", () => {
        notifi.show("Die Verbindung zum Server wurde unterbrochen!", "red")
    })
    
    socket.on("nofifi", function(data){
        notifi.show(data.message, "green")
    })
    submit.addEventListener("click", () => {
        console.log("test")
        socket.emit("sendAlamierung", {
            fahrzeug: document.getElementById("selectFahrzeuge").value,
            id: document.getElementById("id").value,
            an: document.getElementById("Auftragsnummer").value,
            obj: document.getElementById("Objekt").value,
            et: document.getElementById("Etage").value,
            str: document.getElementById("Straße").value,
            hnr: document.getElementById("HNR").value,
            o: document.getElementById("Ort").value,
            ot: document.getElementById("Ortsteil").value,
            sw: document.getElementById("Stichwort").value,
            ei: document.getElementById("Einsatzinformation").value
    })})
</script>