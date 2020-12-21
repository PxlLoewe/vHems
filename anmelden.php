<?php
$db = new mysqli("localhost", "login", "Ighids11", "vHEMS");
if ($db->connect_error) {
    echo $db->connect_error;
}

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $password = $_POST["password"];
    if ($_POST["name"] == "" or $_POST["passwort"]) {
        $response = "<div class='response_ng'>Du musst die Felder ausfüllen</div>";
    } else {
        $password = md5($password);
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND verificationCode = 'verifiziert'");
        $stmt->bind_param('ss', $name, $password);
        $stmt->execute();
        $login = $stmt->get_result();
        if ($login->num_rows == 0) {
            $response = "<div class='response_ng'>Deine Daten sind falsch</div>";
        } elseif ($login->num_rows == 1) {
            $login = $login->fetch_object();
            $_SESSION['userID'] = $login->id;
            $time = time();
            $stmt = $db->prepare("UPDATE users SET lastLogin_at = ? WHERE id = ?");
            $stmt->bind_param('ii', $time, $login->id);
            $stmt->execute();
        
            header("Location: index.php?page={$_GET['page']}");
            $response = "<div class='response_g'>Deine Daten sind richtig</div>";
        }
    }
}
?> <html>

<head>
    <link href="\media\CSS\anmelden.css" rel="stylesheet">
    <title>vHEMS</title>
</head>

<body>
    <div class="box">
        <div class="heading">
            <h1>LOGIN</h1>
            <h3>Das vHEMS Leitstellen System</h3>
        </div>
        <form action="" id="login" method="post"><input class="input-field" name="name" type="text" placeholder="E-Mail"><br><input class="input-field" name="password" type="password" placeholder="Passwort"><br><input class="submit-btn" name="submit" type="submit" value="LOGIN"><br>
        </form><a href="registrieren.php"><button class="reg-btn">Registrieren</button></a> <?php echo $response; ?>
    </div>
</body>

</html>