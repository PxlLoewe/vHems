<?php
$db = new mysqli("localhost", "login", "Ighids11", "vHEMS");
if ($db->connect_error) {
    echo $db->connect_error;
}
if ($_GET["id"] == null) {
    header('Location: index.php');
}

if (isset($_POST["submit"])) {
    echo "hallo";
    $stmt = $db->prepare("UPDATE users SET discordId = ? WHERE id = ?");
    $stmt->bind_param("si", $_POST["discordId"], $_GET["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    header("Location: verify.php?id={$_GET["id"]}");
}

?> <html>

<head>
    <link href="\media\CSS\verify.css" rel="stylesheet">
</head>

<body>
    <div class="box" action="" id="box">
        <div class="heading">
            <h1>Discord ID</h1>
            <h3>Das vHEMS Leitstellen System</h3>
        </div>
        <div class="beschreibung">Benutze den Command " ;;getID " in #bot auf dem Discord Server der vHEMS. Gebe deine ID dann unten ein.</div>
        <form method="post"><input class="input-field" name="discordId" type="text" placeholder="DiscordID"><br>
            <input class="submit-btn" name="submit" type="submit" value="ID ändern"><br>
        </form><a href="verify.php?id=<?php echo $_GET["id"]; ?>">
            <button class="back">zurück</button>
        </a>
    </div>
</body>

</html>