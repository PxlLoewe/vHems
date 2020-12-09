<link rel="stylesheet" href="/subpages/css/dispo.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="/subpages/JS/notify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha512-v8ng/uGxkge3d1IJuEo6dJP8JViyvms0cly9pnbfRxT6/31c3dRWxIiwGnMSWwZjHKOuY3EVmijs7k1jz/9bLA==" crossorigin="anonymous"></script>
<title>Disponieren</title>

<body>
    <div class="grid">
        <div class="Prim">
            <div class="Datum"></div>
            <div class="Uhrzeit"></div>
            <div class="Autragsnummer"><input type="text" placeholder="Auftragsnummer" id="Auftragsnummer"></div>
            <div class="Objekt"><input maxlength="7" type="text" placeholder="Objekt" id="Objekt"></div>
            <div class="Etage"><input maxlength="2" type="text" placeholder="Etage" id="Etage"></div>
            <div class="Straße"><input maxlength="20" type="text" placeholder="Straße" id="Straße"></div>
            <div class="HNR"><input maxlength="3" type="text" placeholder="HNR" id="HNR"></div>
            <div class="Ort"><input maxlength="10" type="text" placeholder="Ort" id="Ort"></div>
            <div class="Ortsteil"><input maxlength="20" type="text" placeholder="Ortsteil" id="Ortsteil"></div>
            <div class="Patient"></div>
            <div class="Anrufer"></div>
            <div class="Stichwort"><input maxlength="22" type="text" placeholder="Stichwort" id="Stichwort"></div>
            <div class="Infos"><input maxlength="150" type="text" placeholder="Einsatzinformation" id="Einsatzinformation"></div>
            <div class="Zusatz"></div>

            <div class="Fahrzeug">
                <select name="activeFahrzeug" class="select" id="selectFahrzeuge">
                    <option>Liste</option>
                    <?php
                    $stmt = $db->query("SELECT * FROM Fahrzeugliste ORDER BY id ASC");

                    while ($Fahrzeuge = $stmt->fetch_object()) { ?>
                        <option><?php echo $Fahrzeuge->Fahrzeuge ?></option>
                    <?php } ?>
                    ?>
                </select>
            </div>
            <div class="Fax"></div>
            <div class="Anlegen"><button id="Anlegen">Alarmierung hinzufügen</button></div>
            <div class="Alarmierung"><button id="Alarmieren" onclick="sendAlarmierung(document.getElementById('selectFahrzeuge').value)">Alarmierung Senden</button></div>
        </div>
        <iframe class="rescuetrack" src="https://rescuetrack.pxlloewe.de" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
        <div class="info">
            <div class="AngelegteEinsätze">
                <table class="InfoTable" id="AngelegteTabelle">
                    <tr>
                        <th class="heading" colspan="4">Angelgte Einsätze</th>
                    </tr>
                    <tr class="cols">
                        <th>Station</th>
                        <th>Ort</th>
                        <th>Stichwort</th>
                    </tr>
                </table>
                <?php
                if ($add == 1) { ?>
                    <div class="Add"><img src="/subpages/media/adds/Banner.gif"></div>
                <?php
                }
                ?>
            </div>
            <div class="LaufendeEinsätze">
                <table class="InfoTable" id="LaufendeTabelle">
                    <tr>
                        <th class="heading" colspan="4">Laufende Einsätze</th>
                    </tr>
                    <tr class="cols">
                        <th>Station</th>
                        <th>Ort</th>
                        <th>Stichwort</th>
                        <th>Alarmiert um</th>
                    </tr>
                </table>
                <?php
                if ($add == 1) { ?>
                    <div class="Add"><img href="http://www.penis.de/" src="/subpages/media/adds/Banner.gif"></div>
                <?php
                }
                ?>
            </div>
            <div class="tableau">
                <table class="InfoTable" id="tableau">
                    <tr>
                        <th colspan='3' class='heading'>Tableau<span onclick="socket.emit('reqData')" class="material-icons refresh">refresh</span></th>
                    </tr>
                    <tr class="cols">
                        <th>Station</th>
                        <th>Status</th>
                        <th>Leitstelle</th>
                    </tr>
                </table>
                <?php
                if ($add == 1) { ?>
                    <div class="Add"><img src="/subpages/media/adds/Banner.gif"></div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    </div>
</body>
<script>
    const tableau = document.getElementById("tableau")
    var socket = io.connect("https://websocket.pxlloewe.de", {
        secure: true
    });

    socket.on("sendData", (data) => {
        while (tableau.rows.length > 2) {
            tableau.deleteRow(2);
        }
        console.log("Daten wurden empfangen!");
        for (var i = 0; i < data.piloten.length; i++) {
            var reihe = tableau.insertRow(-1)

            var station = reihe.insertCell(0)
            var status = reihe.insertCell(1)
            var DCAlarmierung = reihe.insertCell(2)

            station.innerHTML = data.piloten[i].station;
            status.innerHTML = data.piloten[i].status;
            DCAlarmierung.innerHTML = data.piloten[i].lst;
        }

    })
    socket.on("disconnect", () => {
        notifi.show("Die Verbindung zum Server wurde unterbrochen!", "red")
    })

    socket.on("notifi", (data) => {
        if (data.message == "Du bist mit dem Server verbunden!") {
            notifi.show(data.message, "green")
            socket.emit("reqData")
        } else {
            notifi.show(data.message, data.color)
        }

    })

    function sendAlarmierung(fahrzeug) {
        console.log("test")
        socket.emit("sendAlamierung", {
            fahrzeug: fahrzeug,
            id: "wip",
            an: document.getElementById("Auftragsnummer").value,
            obj: document.getElementById("Objekt").value,
            et: document.getElementById("Etage").value,
            str: document.getElementById("Straße").value,
            hnr: document.getElementById("HNR").value,
            o: document.getElementById("Ort").value,
            ot: document.getElementById("Ortsteil").value,
            sw: document.getElementById("Stichwort").value,
            ei: document.getElementById("Einsatzinformation").value
        })
    }
</script>