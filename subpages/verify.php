<?php
$db = new mysqli("localhost", "login", "Ighids11", "vHEMS");
if ($db->connect_error) {
    echo $db->connect_error;
}

if ($_GET["id"] == null) {
    header('Location: index.php');
}
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param('i', $_GET["id"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: index.php');
}
?>
<html>

<head>
    <title>Verifizieren</title>
    <link href="\media\CSS\verify.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha512-v8ng/uGxkge3d1IJuEo6dJP8JViyvms0cly9pnbfRxT6/31c3dRWxIiwGnMSWwZjHKOuY3EVmijs7k1jz/9bLA==" crossorigin="anonymous"></script>

</head>

<body>
    <div class="box" id="box">
        <div class="heading">
            <h1>Verification</h1>
            <h3>Das vHEMS Leitstellen System</h3>
        </div>
        <div class="beschreibung">Dir wurde per Discord ein Verifizierungscode gesendet. Bitte gebe den Code nun unten ein. Falls du keinen Code bekommen hast, stelle sicher dass du auf dem <a class="link" href="https://discord.gg/TaSP35f">vHEMS Discord Server</a> bist. Ist deine ID falsch, kannst du sie <a class="link" href="changeDcID.php?id=<?php echo $_GET["id"]; ?>">hier</a> ändern.</div><input class="input-field" id="code" type="text" placeholder="Code"><br><input class="submit-btn" id="submit" type="submit" value="Verifizieren"><br>
        <div class="response_ng" id="res_ng"></div>
        <div class="response_g" id="res_g"></div>
    </div>
</body>

</html>
<script>
var socket = io.connect("https://websocket.pxlloewe.de", {
        secure: true
    });

    socket.on("notifi", function(data) {
    if (data.message == "Du bist mit dem Server verbunden!") {
        socket.emit("newVerifizierung", {
            id: <?php echo $_GET["id"] ?>
        })
    }
})
socket.on("verifyResponse", (data) => {
    while (data == {}) {
        socket.emit("checkCode", {
            id: <?php echo $_GET["id"] ?>,
            code: document.getElementById("code").value
        })
    }
    console.log(data)
    if (data.result == true) {
        document.getElementById("res_ng").innerHTML = ""
        document.getElementById("res_g").innerHTML = data.text;
        setTimeout(() => {
            window.location.href = "index.php";
        }, 1000)
    } else {
        document.getElementById("code").value = ""
        document.getElementById("res_ng").innerHTML = data.text;
    }
})
document.getElementById("submit").addEventListener("click", () => {
    console.log(document.getElementById("code").value)
    socket.emit("checkCode", {
        id: <?php echo $_GET["id"] ?>,
        code: document.getElementById("code").value
    })
})
function getQueryVariable(variable){
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}
</script>