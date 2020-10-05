<?php
$db = new mysqli("185.248.140.14","Test","test","mysqlcshap");
if($db->connect_error){
    echo $db->connect_error;
}
?>

<html>
    <head>
    <link rel="stylesheet" href="/subpages/css/pilot.css">
    <script src="/subpages/JS/pilot.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"></head>

<div id="overlay" class="active"></div>
<div id="auswahl-box", class="active">
    <select name="activeFahrzeug" id="activeFahrzeuge">
    <?php
        $stmt = $db->query("SELECT * FROM Fahrzeugliste ORDER BY id ASC");
        ?>
        <option>Bitte Wähle dein Fahrzeug aus der Liste aus</option>
        <?php
        while($Fahrzeuge = $stmt->fetch_object()) { ?>
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
            </div>
            <div class="RedButton">
                <button></button>
            </div>
            <div class="GreyButton">
                <button></button>
            </div>
            <span id="openMelder" class="material-icons openInNew">open_in_new</span>
        </div>
    </div>
</div>
<iframe class="right" src="https://rescuetrack.pxlloewe.de" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha512-v8ng/uGxkge3d1IJuEo6dJP8JViyvms0cly9pnbfRxT6/31c3dRWxIiwGnMSWwZjHKOuY3EVmijs7k1jz/9bLA==" crossorigin="anonymous"></script>
<script>
const overlay = document.getElementById("overlay");
const auswahlBox = document.getElementById("auswahl-box");
const selectedFahrzeug = document.getElementById("activeFahrzeuge");
const selectedFahrzeugButton = document.getElementById("selectActive");
const eingelogtPilot = document.getElementById("eingelogtPilot");
const connWarning = document.getElementById("connWarning");
const openMelder = document.getElementById("openMelder");
//Formular
//socket.IO connect
var socket = io.connect("https://websocket.pxlloewe.de", {secure: true});

socket.on("disconnect", () => {
    notifi.show("Die Verbindung zum Server wurde unterbrochen!", "red")
    connWarning.style.color = "rgba(255, 0, 0, 1)";
})
selectedFahrzeugButton.addEventListener("click", function(io) {
    console.log(selectedFahrzeug.value, "wurde ausgewählt")
    auswahlBox.classList.remove("active");
    overlay.classList.remove("active");
    eingelogtPilot.innerHTML = selectedFahrzeug.value;
    socket.emit("newPilot", {
        realName: "<?php echo $user->vorname; ?>",
        station: selectedFahrzeug.value,
  })
  });

openMelder.addEventListener("click", () => {
    window.open('https://javascript.info');
})

function newAlamierung(data){
    var audio = new Audio();
    audio.src = "./media/test.mp3";
    audio.play();
    console.log(data)
    document.getElementById("display").innerHTML = data.id + data.an + data.obj

}
socket.on("alamierung", function(data){
    newAlamierung(data.id)
})
socket.on("nofifi", function(data){
    notifi.show(data.message, "green")
    if(data.message == "Du bist mit dem Server verbunden!"){
        console.log("connected")
        connWarning.style.color = "rgba(255, 0, 0, 0)";
    }
})

</script>
</html>
