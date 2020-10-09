<?php
$db = new mysqli("185.248.140.14", "Test", "test", "mysqlcshap");
if ($db->connect_error) {
    echo $db->connect_error;
}
?>

<html>

<head>
    <link rel="stylesheet" href="/subpages/css/pilot.css">
    <script src="/subpages/JS/pilot.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<div id="overlay" class="active"></div>
<div id="auswahl-box" , class="active">
    <select name="activeFahrzeug" id="activeFahrzeuge">
        <?php
        $stmt = $db->query("SELECT * FROM Fahrzeugliste ORDER BY id ASC");
        ?>
        <option>Bitte Wähle dein Fahrzeug aus der Liste aus</option>
        <?php
        while ($Fahrzeuge = $stmt->fetch_object()) { ?>
            <option><?php echo $Fahrzeuge->Fahrzeuge ?></option>
        <?php } ?>
        ?>
    </select>
    <button id="selectActive">bestätigen</button>
</div>
<div class="left">
    <div id="eingelogtPilot" class="Pilot"></div>
    <span id="connWarning" class="material-icons show">signal_cellular_connected_no_internet_4_bar</span>
    <!-- Hier wird die Alamierung angezeigt!   -->
    <div class="melder">
        <img class="melder_Img" src="/subpages/media/melder.png">
        <div id="display" class="Display">
            <div class="row1col1"><div id="displayText1" class="displayText1"></div></div>
            <div class="row1col2"><div id="displayText2" class="displayText2"></div></div>
            <div class="row2col1"><div id="displayText3" class="displayText3"></div></div>
            <div class="row2col2"><div id="displayText4" class="displayText4"></div></div>
            <div class="row3col1"><div id="displayText5" class="displayText5"></div></div>
            <div class="row3col2"><div id="displayText6" class="displayText6"></div></div>
            <div class="row4col1"><div id="displayText7" class="displayText7"></div></div>
            <div class="row4col2"><div id="displayText8" class="displayText8"></div></div>
        </div>
        <div class="RedButton">
            <button id="redButton"></button>
        </div>
        <div class="greyUp">
            <button></button>
        </div>
    </div>
    <span id="openMelder" class="material-icons openInNew">open_in_new</span>
</div>
</div>
<iframe class="right" src="https://rescuetrack.pxlloewe.de" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha512-v8ng/uGxkge3d1IJuEo6dJP8JViyvms0cly9pnbfRxT6/31c3dRWxIiwGnMSWwZjHKOuY3EVmijs7k1jz/9bLA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js" integrity="sha512-Izh34nqeeR7/nwthfeE0SI3c8uhFSnqxV0sI9TvTcXiFJkMd6fB644O64BRq2P/LA/+7eRvCw4GmLsXksyTHBg==" crossorigin="anonymous"></script>
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
    const display = {
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
    var redButtonTimeout;
    var IdleInterval;
    var displayState = "on"
    //socket.IO connect
    var socket = io.connect("https://websocket.pxlloewe.de", {
        secure: true
    });

    socket.on("disconnect", () => {
        notifi.show("Die Verbindung zum Server wurde unterbrochen!", "red")
        connWarning.style.color = "rgba(255, 0, 0, 1)";
    })
    selectedFahrzeugButton.addEventListener("click", function(io) {
        console.log(selectedFahrzeug.value, "wurde ausgewählt")
        auswahlBox.classList.remove("active");
        overlay.classList.remove("active");
        eingelogtPilot.innerHTML = selectedFahrzeug.value;
        Display.Idle();
        socket.emit("newPilot", {
            realName: "<?php echo $user->vorname; ?>",
            station: selectedFahrzeug.value,
        })
    });
    function test(){
    }
    redButton.addEventListener("mousedown", function(){
        if(Display.state == "on"){
            redButtonTimeout = setTimeout(Display.shutdown,2000)
        }else if(Display.state == "off"){
            redButtonTimeout = setTimeout(Display.startup,2000)
        } 
    })
    redButton.addEventListener("mouseup", () => {
        clearTimeout(redButtonTimeout)
    
    })
    openMelder.addEventListener("click", () => {
        window.open('https://javascript.info');
    })
    var Display = {
        state: displayState,
        Idle: function(){
            Display.state = "on";
            display.Text2.className = "displayText2 Idle";
            IdleInterval = setInterval(timerPreset, 1000)
            function timerPreset(){
                const m = moment()
                var Datum = m.format("dd") + " " + m.format("D") + "." + m.format("MMM")+ " " + m.format("YYYY")
                var Uhrzeit = m.format("HH") + ":" + m.format("mm")
                display.Text2.innerHTML = "<span class='material-icons'>battery_full</span>"
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
        Alamierung: function(data){
        clearInterval(Display.Idle);
        console.log(data);
        },
        startup: function(){
            display.Text3.innerHTML = "Shutting up <span id='loading'>.</span>";
            display.Text2.className = "displayText2 with";
            setTimeout(() => {
                Display.Idle();
            }, 3000)
        },
        reset: function(){
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
        shutdown: function(){
            Display.stopIdle();
            Display.reset();
            display.Text3.innerHTML = "Shutting Down <span id='loading'>.</span>";
            display.Text2.className = "displayText2 width";
            setTimeout(() => {
                display.Text3.innerHTML = "";
                display.Text2.className = "displayText2";
                Display.state = "off"
            }, 3000)
        },
    }
        setInterval(() => {
            if(document.getElementById("loading")){
                if(document.getElementById("loading").innerHTML.length < 3){
                    document.getElementById("loading").innerHTML += "."
                }else{
                    document.getElementById("loading").innerHTML = "."
                }
            }
        },800)

    function newAlamierung(data) {
        var audio = new Audio();
        audio.src = "./media/test.mp3";
        audio.play();
        console.log(data)
    }
    socket.on("alamierung", function(data) {
        Display.Alamierung(data)
    })
    socket.on("nofifi", function(data) {
        notifi.show(data.message, "green")
        if (data.message == "Du bist mit dem Server verbunden!") {
            console.log("connected")
            connWarning.style.color = "rgba(255, 0, 0, 0)";
        }
    })
</script>
</html>