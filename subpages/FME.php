<head>
    <link rel="stylesheet" href="/subpages/css/FME.css">
    <script src="/subpages/JS/notify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha512-v8ng/uGxkge3d1IJuEo6dJP8JViyvms0cly9pnbfRxT6/31c3dRWxIiwGnMSWwZjHKOuY3EVmijs7k1jz/9bLA==" crossorigin="anonymous"></script>

</head>
<body>
<div class="FME">
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
</body>
<script>

    var socket = io.connect("https://websocket.pxlloewe.de", {
        secure: true
    });
    socket.emit("newPilot", {
        userID: "<?php echo $_GET["userID"]; ?>",
        station: "<?php echo $_GET["station"]; ?>",
        popup: true,
        discordAlarmierung: "/"
    })

    socket.on("statusReturn", (data) => {
        document.getElementById("FMEstatus").innerHTML = "S " + data
    })

    function updateStatus(s) {
        socket.emit("updateStatus", {
            fahrzeug: `<?php echo $_GET["station"]; ?>`,
            status: s
        })
        console.log("Status")
    }
    
</script>