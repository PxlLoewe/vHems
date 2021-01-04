<link rel="stylesheet" href="/subpages/css/dispo.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="/subpages/JS/notify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha512-v8ng/uGxkge3d1IJuEo6dJP8JViyvms0cly9pnbfRxT6/31c3dRWxIiwGnMSWwZjHKOuY3EVmijs7k1jz/9bLA==" crossorigin="anonymous"></script>
<script type="text/JavaScript" src=" https://MomentJS.com/downloads/moment.js"></script>
<title>Disponieren</title>

<body>
    <div class="grid">
        <div class="forms">
            <div class="edit" id="edit">
                <div class="Datum"></div>
                <div class="Uhrzeit"></div>
                <div class="Autragsnummer"><input type="text" placeholder="Auftragsnummer" id="Auftragsnummer2"></div>
                <div class="Objekt"><input maxlength="7" type="text" placeholder="Objekt" id="Objekt2"></div>
                <div class="Etage"><input maxlength="2" type="text" placeholder="Etage" id="Etage2"></div>
                <div class="Straße"><input maxlength="20" type="text" placeholder="Straße" id="Straße2"></div>
                <div class="HNR"><input maxlength="3" type="text" placeholder="HNR" id="HNR2"></div>
                <div class="Ort"><input maxlength="10" type="text" placeholder="Ort" id="Ort2"></div>
                <div class="Ortsteil"><input maxlength="20" type="text" placeholder="Ortsteil" id="Ortsteil2"></div>
                <div class="Patient"></div>
                <div class="Anrufer"></div>
                <div class="Stichwort"><input maxlength="22" type="text" placeholder="Stichwort" id="Stichwort2"></div>
                <div class="Infos"><input maxlength="150" type="text" placeholder="Einsatzinformation" id="Einsatzinformation2"></div>
                <div class="Fahrzeug">
                    <select name="activeFahrzeug" class="select" id="selectFahrzeuge2">
                        <option>Liste</option>
                        <?php
                        $stmt = $db->query("SELECT * FROM Fahrzeugliste ORDER BY id ASC");

                        while ($Fahrzeuge = $stmt->fetch_object()) { ?>
                            <option><?php echo $Fahrzeuge->Fahrzeuge ?></option>
                        <?php } ?>
                        ?>
                    </select>
                    <div class="Anlegen"><button onclick="editPrimMission()" id="Anlegen">Alarmierung hinzufügen</button></div>
                </div>
            </div>
            <div class="head">
                <button id="switchPrim">Primäreinsätze</button>
                <button id="switchSek">Sekundäreinsätze</button>
            </div>

            <div id="body" class="switch">
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
                    <div class="Anlegen"><button onclick="addPrimMission(document.getElementById('selectFahrzeuge').value)" id="Anlegen">Hinzufügen</button></div>
                    <div class="Alarmierung"><button id="Alarmieren" onclick="sendAlarmierung(document.getElementById('selectFahrzeuge').value)">Alarm</button></div>

                </div>
                <div class="Sek">
                    Sek
                </div>
            </div>
        </div>
        <iframe class="rescuetrack" src="https://vhems.pxlloewe.de/rescuetrack" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
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
                        <th>Aktionen</th>
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
                        <th class="heading" colspan="5">Laufende Einsätze</th>
                    </tr>
                    <tr class="cols">
                        <th>Station</th>
                        <th>Ort</th>
                        <th>Stichwort</th>
                        <th>Alarmiert um</th>
                        <th>Aktionen</th>
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
    const angelegteTabelle = document.getElementById("AngelegteTabelle")
    const laufendeTabelle = document.getElementById("LaufendeTabelle")

    var socket = io.connect("https://websocket.pxlloewe.de", {
        secure: true
    });

    socket.on("sendData", (data) => {
        while (tableau.rows.length > 2) {
            tableau.deleteRow(2);
        }
        for (var i = 0; i < data.piloten.length; i++) {
            var reihe = tableau.insertRow(-1)

            var station = reihe.insertCell(0)
            var status = reihe.insertCell(1)
            var DCAlarmierung = reihe.insertCell(2)

            station.innerHTML = data.piloten[i].station;
            status.innerHTML = data.piloten[i].status;
            DCAlarmierung.innerHTML = data.piloten[i].lst;
        }
        while (angelegteTabelle.rows.length > 2) {
            angelegteTabelle.deleteRow(2);
        }
        for (var i = 0; i < data.angelegte.length; i++) {

            angelegteTabelle.innerHTML += `<tr><td>${data.angelegte[i].station}</td><td>${data.angelegte[i].ort}</td><td>${data.angelegte[i].sw}</td><td><button class="iconButton" onclick="sendAlarmierungByID(${data.angelegte[i].id})"><span class="material-icons">notifications</span></button><button class="iconButton" onclick="deleteAlarmierungByID(${data.angelegte[i].id})"><span class="material-icons">delete</span></button><button class="iconButton" onclick="showEditDiv(${data.angelegte[i].id})"><span class="material-icons">edit</span></button></td></tr>`

        }
        while (laufendeTabelle.rows.length > 2) {
            laufendeTabelle.deleteRow(2);
        }
        for (var i = 0; i < data.laufende.length; i++) {

            laufendeTabelle.innerHTML += `<tr><td>${data.laufende[i].station}</td><td>${data.laufende[i].o}</td><td>${data.laufende[i].sw}</td><td>${data.laufende[i].time}</td><td><button class="iconButton" onclick="archiveMission(${data.laufende[i].id})"><span class="material-icons">archive</span></button></td></tr>`

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

        socket.emit("sendPrimMission", {
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

    function addPrimMission(fahrzeug) {
        console.log(document.getElementById('selectFahrzeuge').value)
        socket.emit("addPrimMission", {
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

    function editPrimMission(id) {
        socket.emit("editPrimMission", {
            fahrzeug: fahrzeug,
            id: "wip",
            an: document.getElementById("Auftragsnummer2").value,
            obj: document.getElementById("Objekt2").value,
            et: document.getElementById("Etage2").value,
            str: document.getElementById("Straße2").value,
            hnr: document.getElementById("HNR2").value,
            o: document.getElementById("Ort2").value,
            ot: document.getElementById("Ortsteil2").value,
            sw: document.getElementById("Stichwort2").value,
            ei: document.getElementById("Einsatzinformation2").value,
            zu: document.getElementById("Zusatzinformation2").value,
        })
        document.getElementById("edit").classList.remove("show")



    }

    function showEditDiv(id) {
        document.getElementById("edit").classList.add("show")
        socket.emit("getMissionInfo", id)
    }
    socket.on("emitMissionInfo", data => {
        document.getElementById("Auftragsnummer2").value = data.an
        document.getElementById("Objekt2").value = data.obj
        document.getElementById("Etage2").value = data.et
        document.getElementById("Straße2").value = data.str
        document.getElementById("HNR2").value = data.hnr
        document.getElementById("Ort2").value = data.o
        document.getElementById("Ortsteil2").value = data.ot
        document.getElementById("Stichwort2").value = data.sw
        document.getElementById("Einsatzinformation2").value = data.ei
    })


    const body = document.getElementById("body")
    document.getElementById("switchPrim").addEventListener("click", () => {
        body.classList.remove("dasfas")
    })
    document.getElementById("switchSek").addEventListener("click", () => {
        body.classList.add("dasfas")
    })

    function sendAlarmierungByID(id) {
        socket.emit("sendAlarmierungByID", id)
    }

    function deleteAlarmierungByID(id) {
        socket.emit("deleteAlarmierungByID", id)
    }

    function archiveMission(id) {
        socket.emit("deleteMissionByID", id)
    }
</script>