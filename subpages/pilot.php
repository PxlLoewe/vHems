<?php
$db = new mysqli("localhost","login","Ighids11","vHEMS");
if($db->connect_error){
    echo $db->connect_error;
}
?>

<html>

<head>
    <link rel="stylesheet" href="/subpages/css/pilot.css">
    <script src="/subpages/JS/notify.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha512-v8ng/uGxkge3d1IJuEo6dJP8JViyvms0cly9pnbfRxT6/31c3dRWxIiwGnMSWwZjHKOuY3EVmijs7k1jz/9bLA==" crossorigin="anonymous"></script>
</head>

<div id="overlay" class="active"></div>
<div id="auswahl-box" , class="active">
    <div class="heading">
        <h1>Fahrzeug</h1>
    </div>
    <select class="selectFahrzeug" name="activeFahrzeug" id="activeFahrzeuge">
        <?php
        $stmt = $db->query("SELECT * FROM Fahrzeugliste ORDER BY id ASC");
        ?>
        <?php
        while ($Fahrzeuge = $stmt->fetch_object()) { ?>
            <option><?php echo $Fahrzeuge->Fahrzeuge ?></option>
        <?php } ?>
        ?>
    </select><br>
    <div class="Discord">
        <input id="discordAlarmierung" type="checkbox" name="discordAlamierung" value="discordCheck" checked>
        <label class="labelDiscordAlarmierung" for="discordCheck">Möchtest du auf Discord Alamiert
            werden?</label><br><br>
    </div>
    <button class="submit-btn" id="selectActive">CONFIRM</button>
</div>
<div class="left">
    <?php 
    if($add == 1){ ?>
        <div href="http://www.penis.de/" class="Add"><img href="http://www.penis.de/" src="/subpages/media/adds/Banner.gif"></div>
    <?php
    }
    ?>
    <div id="eingelogtPilot" class="Pilot"></div>
    <span id="connWarning" class="material-icons show">signal_cellular_connected_no_internet_4_bar</span>
    <!-- Hier wird die Alamierung angezeigt!   -->
    <div class="leftGrid">
        <div class="melder">
            <img class="melder_Img" src="/subpages/media/melder.png">
            <div id="display" class="DisplayMelder">
                <div id="row1col1" class="row1col1">
                    <div id="displayText1" class="displayText1"></div>
                </div>
                <div id="row1col2" class="row1col2">
                    <div id="displayText2" class="displayText2"></div>
                </div>
                <div id="row2col1" class="row2col1">
                    <div id="displayText3" class="displayText3"></div>
                </div>
                <div id="row2col2" class="row2col2">
                    <div id="displayText4" class="displayText4"></div>
                </div>
                <div id="row3col1" class="row3col1">
                    <div id="displayText5" class="displayText5"></div>
                </div>
                <div id="row3col2" class="row3col2">
                    <div id="displayText6" class="displayText6"></div>
                </div>
                <div id="row4col1" class="row4col1">
                    <div id="displayText7" class="displayText7"></div>
                </div>
                <div id="row4col2" class="row4col2">
                    <div id="displayText8" class="displayText8"></div>
                </div>
            </div>
            <div class="RedButton">
                <button id="redButton"></button>
            </div>
            <div class="greyUp">
                <button id="greyUp"></button>
            </div>
            <div class="Attachements">
                <span id="openMelder" class="openInNew material-icons">open_in_new</span>
            </div>
        </div>
        <div class="FME">
            <span id="openFME" class="openInNew material-icons">open_in_new</span>
            <img src="/subpages/media/FME.png">
            <div id="FMEstatus" class="displayFMEupper"></div>
            <div class="displayFMElower"></div>
            <div class="FMEkey1"><button onclick="updateStatus(1)" class="FMEkeyButton"></button></div>
            <div class="FMEkey2"><button onclick="updateStatus(2)" class="FMEkeyButton"></button></div>
            <div class="FMEkey3"><button onclick="updateStatus(3)" class="FMEkeyButton"></button></div>
            <div class="FMEkey4"><button onclick="updateStatus(4)" class="FMEkeyButton"></button></div>
            <div class="FMEkey5"><button onclick="updateStatus(5)" class="FMEkeyButton"></button></div>
            <div class="FMEkey6"><button onclick="updateStatus(6)" class="FMEkeyButton"></button></div>
            <div class="FMEkey7"><button onclick="updateStatus(7)" class="FMEkeyButton"></button></div>
            <div class="FMEkey8"><button onclick="updateStatus(8)" class="FMEkeyButton"></button></div>
            <div class="FMEkey9"><button onclick="updateStatus(9)" class="FMEkeyButton"></button></div>
            <div class="FMEkey0"><button onclick="updateStatus(0)" class="FMEkeyButton"></button></div>
        </div>
    </div>
</div>
</div>
</div>
<iframe class="right" src="/rescuetrack" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
<script>
    const redButton = document.getElementById("redButton");
    const greyUp = document.getElementById("greyUp");
    const overlay = document.getElementById("overlay");
    const auswahlBox = document.getElementById("auswahl-box");
    const selectedFahrzeug = document.getElementById("activeFahrzeuge");
    const selectedFahrzeugButton = document.getElementById("selectActive");
    const eingelogtPilot = document.getElementById("eingelogtPilot");
    const connWarning = document.getElementById("connWarning");
    const openMelder = document.getElementById("openMelder");
    const openFME = document.getElementById("openFME")
    const display = {
        row1col1: document.getElementById("row1col1"),
        row1col2: document.getElementById("row1col2"),
        row2col1: document.getElementById("row2col1"),
        row2col2: document.getElementById("row2col2"),
        row3col1: document.getElementById("row3col1"),
        row3col2: document.getElementById("row3col2"),
        row4col1: document.getElementById("row4col1"),
        row4col2: document.getElementById("row4col2"),
        display: document.getElementById("display"),
        Text1: document.getElementById("displayText1"),
        Text2: document.getElementById("displayText2"),
        Text3: document.getElementById("displayText3"),
        Text4: document.getElementById("displayText4"),
        Text5: document.getElementById("displayText5"),
        Text6: document.getElementById("displayText6"),
        Text7: document.getElementById("displayText7"),
        Text8: document.getElementById("displayText8"),
    }
    //Formular
    var AlamierungSound = new Audio();
    var redButtonTimeout;
    var IdleInterval;
    var displayState = "on"
    var displayShowing;
    var melderConnWarning;
    //socket.IO connect
    var Display = {
        state: displayState,
        showing: displayShowing,
        Idle: function() {
            Display.reset()
            Display.showing = "Idle"
            Display.state = "on";
            display.Text1.className = "displayText1 Idle";
            display.Text2.className = "displayText2 Idle";
            IdleInterval = setInterval(timerPreset, 1000)

            function timerPreset() {
                const m = moment()
                var Datum = m.format("dd") + " " + m.format("D") + "." + m.format("MMM") + " " + m.format("YYYY")
                var Uhrzeit = m.format("HH") + ":" + m.format("mm")
                display.Text1.innerHTML =
                    "<img class='speaker' src='/subpages/media/Ton.png'><img id='connImg' class='connectionIndicator active' src='/subpages/media/Empfang.png'>"
                display.Text2.innerHTML = "<img class='battery' src='/subpages/media/Batt.png'>"
                display.Text7.innerHTML = Datum;
                display.Text8.innerHTML = Uhrzeit;
                display.Text3.innerHTML = "Nachrichtent."
                display.Text4.innerHTML = "EMMERL"
            }
        },
        stopIdle: function() {
            clearInterval(IdleInterval)
            Display.reset();
        },
        Alamierung: function(data) {
            if (Display.state == "on") {
                Display.showing = "alerted"
                Display.stopIdle();
                Display.reset();
                AlamierungSound.src = "./media/Melder.mp3";
                AlamierungSound.play();
                setTimeout(() => {
                    display.row1col1.className = "row1col1 width"
                    display.row2col1.className = "row2col1 width"
                    display.row4col1.className = "row4col1 width"
                    setTimeout(() => {
                        display.Text1.innerHTML = data.sw;
                    }, 100)
                    setTimeout(() => {
                        display.Text3.innerHTML = data.str
                    }, 200)
                    setTimeout(() => {
                        display.Text4.innerHTML = data.hnr
                    }, 300)
                    setTimeout(() => {
                        display.Text5.innerHTML = data.o;
                    }, 400)
                    setTimeout(() => {
                        display.Text6.innerHTML = data.obj
                    }, 500)
                    setTimeout(() => {
                        display.Text7.innerHTML = data.ei
                    }, 600)
                }, 2000)
            }
        },
        startup: function() {
            display.Text3.innerHTML = "Shutting up <span id='loading'>.</span>";
            display.Text2.className = "displayText2 with";
            setTimeout(() => {
                Display.Idle();
            }, 3000)
        },
        reset: function() {
            display.row1col1.className = "row1col1"
            display.row1col2.className = "row1col2"
            display.row2col1.className = "row2col1"
            display.row2col2.className = "row2col2"
            display.row3col1.className = "row3col1"
            display.row3col2.className = "row3col2"
            display.row4col1.className = "row4col1"
            display.row4col2.className = "row4col2"
            display.Text1.className = "displayText1"
            display.Text2.className = "displayText2"
            display.Text3.className = "displayText3"
            display.Text4.className = "displayText4"
            display.Text5.className = "displayText5"
            display.Text6.className = "displayText6"
            display.Text7.className = "displayText7"
            display.Text8.className = "displayText8"
            display.Text1.innerHTML = "";
            display.Text2.innerHTML = "";
            display.Text3.innerHTML = "";
            display.Text4.innerHTML = "";
            display.Text5.innerHTML = "";
            display.Text6.innerHTML = "";
            display.Text7.innerHTML = "";
            display.Text8.innerHTML = "";
        },
        shutdown: function() {
            Display.stopIdle();
            Display.reset();
            display.Text3.innerHTML = "Shutting Down <span id='loading'>.</span>";
            display.row2col1.className = "row2col1 width";
            setTimeout(() => {
                display.Text3.innerHTML = "";
                display.Text2.className = "displayText2";
                Display.state = "off"
                Display.showing = "none"
            }, 3000)
        },
    }
    setInterval(() => {
        if (document.getElementById("loading")) {
            if (document.getElementById("loading").innerHTML.length < 3) {
                document.getElementById("loading").innerHTML += "."
            } else {
                document.getElementById("loading").innerHTML = "."
            }
        }
    }, 800)
    var socket = io.connect("https://websocket.pxlloewe.de", {
        secure: true
    });
    socket.on("statusReturn", (data) => {
        document.getElementById("FMEstatus").innerHTML = "S " + data
    })

    function updateStatus(s) {
        socket.emit("updateStatus", {
            fahrzeug: document.getElementById("eingelogtPilot").innerHTML,
            status: s
        })
        console.log("Status")
    }

    socket.on("disconnect", () => {
        notifi.show("Die Verbindung zum Server wurde unterbrochen!", "red")
        connWarning.style.color = "rgba(255, 0, 0, 1)";
        melderConnWarning = setInterval(() => {
            var an;
            if (an == 1) {
                an = 0
                document.getElementById("connImg").className = "connectionIndicator active";
            } else {
                an = 1
                document.getElementById("connImg").className = "connectionIndicator";
            }
        }, 1000)
    })
    selectedFahrzeugButton.addEventListener("click", function(io) {
        console.log(selectedFahrzeug.value, "wurde ausgewählt")
        auswahlBox.classList.remove("active");
        overlay.classList.remove("active");
        eingelogtPilot.innerHTML = selectedFahrzeug.value;
        Display.Idle();
        socket.emit("newPilot", {
            userID: "<?php echo $user->id; ?>",
            station: selectedFahrzeug.value,
            popup: false,
            discordAlarmierung: document.getElementById("discordAlarmierung").checked
        })
        updateStatus(2)
    });
    greyUp.addEventListener("mousedown", () => {
        if (Display.showing == "alerted") {
            Display.Idle()
            AlamierungSound.pause();
            AlamierungSound.currentTime = 0;
        }
    })
    redButton.addEventListener("mousedown", function() {
        if (Display.state == "on") {
            redButtonTimeout = setTimeout(Display.shutdown, 2000)
        } else if (Display.state == "off") {
            redButtonTimeout = setTimeout(Display.startup, 2000)
        }
        if (Display.showing == "alerted") {
            AlamierungSound.pause();
            AlamierungSound.currentTime = 0;
        }
    })
    redButton.addEventListener("mouseup", () => {
        clearTimeout(redButtonTimeout)
    })
    openMelder.addEventListener("click", () => {
        window.open(
            `https://vhems.pxlloewe.de/openInNew.php?form=melder&station=${selectedFahrzeug.value}&userId=<?php echo $user_id; ?>&dcAlarmierung=${document.getElementById("discordAlarmierung").checked}`,
            null,
            "height=400,width=285,status=yes,toolbar=no,menubar=no,location=no"
        );
    })

    openFME.addEventListener("click", () => {
        window.open(
            `https://vhems.pxlloewe.de/openInNew.php?form=FME&station=${selectedFahrzeug.value}&userID=<?php echo $user_id; ?>`,
            null,
            "height=600,width=264,status=yes,toolbar=no,menubar=no,location=no"
        );
    })

    socket.on("alamierung", function(data) {
        Display.Alamierung(data)
    })
    socket.on("notifi", function(data) {
        notifi.show(data.message, "green")
        if (data.message == "Du bist mit dem Server verbunden!") {
            clearInterval(melderConnWarning)
            console.log("connected")
            connWarning.style.color = "rgba(255, 0, 0, 0)";
            if (eingelogtPilot.innerHTML != "") {
                socket.emit("newPilot", {
                    userID: "<?php echo $user->id; ?>",
                    station: selectedFahrzeug.value,
                    popup: false,
                    discordAlarmierung: document.getElementById("discordAlarmierung").checked
                })
            }
        }
    })
</script>

</html>