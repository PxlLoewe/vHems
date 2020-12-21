<body>
    <head>
        <title>Melder</title>
        <link rel="stylesheet" href="/subpages/css/melder.css">
        <script src="/subpages/JS/notify.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha512-v8ng/uGxkge3d1IJuEo6dJP8JViyvms0cly9pnbfRxT6/31c3dRWxIiwGnMSWwZjHKOuY3EVmijs7k1jz/9bLA==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js" integrity="sha512-Izh34nqeeR7/nwthfeE0SI3c8uhFSnqxV0sI9TvTcXiFJkMd6fB644O64BRq2P/LA/+7eRvCw4GmLsXksyTHBg==" crossorigin="anonymous"></script>
</head>
    <div id="melder" class="melder">
            <img class="melder_Img" src="/subpages/media/melder.png">
            <div id="display" class="Display">
                <div id="row1col1" class="row1col1"><div id="displayText1" class="displayText1"></div></div>
                <div id="row1col2" class="row1col2"><div id="displayText2" class="displayText2"></div></div>
                <div id="row2col1" class="row2col1"><div id="displayText3" class="displayText3"></div></div>
                <div id="row2col2" class="row2col2"><div id="displayText4" class="displayText4"></div></div>
                <div id="row3col1" class="row3col1"><div id="displayText5" class="displayText5"></div></div>
                <div id="row3col2" class="row3col2"><div id="displayText6" class="displayText6"></div></div>
                <div id="row4col1" class="row4col1"><div id="displayText7" class="displayText7"></div></div>
                <div id="row4col2" class="row4col2"><div id="displayText8" class="displayText8"></div></div>
            </div>
            <div class="RedButton">
                <button id="redButton"></button>
            </div>
            <div class="greyUp">
                <button id="greyUp"></button>
            </div>
        </div>
</body>
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
        row1col1:   document.getElementById("row1col1"),
        row1col2:   document.getElementById("row1col2"),
        row2col1:   document.getElementById("row2col1"),
        row2col2:   document.getElementById("row2col2"),
        row3col1:   document.getElementById("row3col1"),
        row3col2:   document.getElementById("row3col2"),
        row4col1:   document.getElementById("row4col1"),
        row4col2:   document.getElementById("row4col2"),
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
        Idle: function(){
            Display.reset()
            Display.showing = "Idle"
            Display.state = "on";
            display.Text1.className = "displayText1 Idle";
            display.Text2.className = "displayText2 Idle";
            IdleInterval = setInterval(timerPreset, 1000)
            function timerPreset(){
                const m = moment()
                var Datum = m.format("dd") + " " + m.format("D") + "." + m.format("MMM")+ " " + m.format("YYYY")
                var Uhrzeit = m.format("HH") + ":" + m.format("mm")
                display.Text1.innerHTML = "<img class='speaker' src='/subpages/media/Ton.png'><img id='connImg' class='connectionIndicator active' src='/subpages/media/Empfang.png'>"
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
        Alamierung: function(data){
            if(Display.state == "on"){
            Display.showing = "alerted"
            Display.stopIdle();
            Display.reset();
            AlamierungSound.src = "./media/Melder.mp3";
            AlamierungSound.play();
            setTimeout(() => {
                display.row1col1.className = "row1col1 width"
                display.row2col1.className = "row2col1 width"
                display.row4col1.className = "row4col1 width"
                setTimeout(() => {display.Text1.innerHTML = data.sw;}, 100)
                setTimeout(() => {display.Text3.innerHTML = data.str}, 200)
                setTimeout(() => {display.Text4.innerHTML = data.hnr}, 300)
                setTimeout(() => {display.Text5.innerHTML = data.o;}, 400)
                setTimeout(() => {display.Text6.innerHTML = data.obj}, 500)
                setTimeout(() => {display.Text7.innerHTML = data.ei}, 600)
            }, 2000)
            }
        },
        startup: function(){
            display.Text3.innerHTML = "Shutting up <span id='loading'>.</span>";
            display.Text2.className = "displayText2 with";
            setTimeout(() => {
                Display.Idle();
            }, 3000)
        },
        reset: function(){
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
        shutdown: function(){
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
            if(document.getElementById("loading")){
                if(document.getElementById("loading").innerHTML.length < 3){
                    document.getElementById("loading").innerHTML += "."
                }else{
                    document.getElementById("loading").innerHTML = "."
                }
            }
        },800)
    var socket = io.connect("https://websocket.pxlloewe.de", {
        secure: true
    });
    socket.on("disconnect", () => {
        notifi.show("Die Verbindung zum Server wurde unterbrochen!", "red")
        melderConnWarning = setInterval(() => {
            var an;
            if(an == 1){
            an = 0
            document.getElementById("connImg").className = "connectionIndicator active";
            }else{
                an = 1
                document.getElementById("connImg").className = "connectionIndicator";
            }
        }, 1000)
    })

    // Login als Pilot:
        Display.Idle();
    
        greyUp.addEventListener("mousedown", () => {
        if(Display.showing == "alerted"){
            Display.Idle()
            AlamierungSound.pause();
            AlamierungSound.currentTime = 0;
        }
    })
    redButton.addEventListener("mousedown", function(){
        if(Display.state == "on"){
            redButtonTimeout = setTimeout(Display.shutdown,2000)
        }else if(Display.state == "off"){
            redButtonTimeout = setTimeout(Display.startup,2000)
        } 
        if(Display.showing == "alerted"){
            AlamierungSound.pause();
            AlamierungSound.currentTime = 0;
        }
    })
    redButton.addEventListener("mouseup", () => {
        clearTimeout(redButtonTimeout)
    })

    socket.on("alamierung", function(data) {
        Display.Alamierung(data)
    })
    socket.on("notifi", function(data) {
        notifi.show(data.message, "green")
        if (data.message == "Du bist mit dem Server verbunden!") {
            clearInterval(melderConnWarning)
            console.log("connected")
                socket.emit("newPilot", {
                    userID: "<?php echo $_GET["userId"];?>",
                    station: "<?php echo $_GET["station"];?>",
                    popup: true,
                    discordAlarmierung: "<?php echo $_GET["dcAlarmierung"];?>"
                })
        }
    })
</script>