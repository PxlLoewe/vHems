<?php
$db = new mysqli("localhost", "login", "Ighids11", "vHEMS");
if ($db->connect_error) {
    echo $db->connect_error;
}

if (isset($_POST['absenden'])) :

    $name = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $discordID = $_POST['discordID'];
    $mail = $_POST['mail'];
    $passwort = $_POST['passwort'];
    $passwort_wiederholen = $_POST['passwort_wiederholen'];
    $zero = "0";
    $leer = "";
    $time = time();

    if ($name !== "" and $uplay !== "" and $mail !== "" and $discordID !== "" and $passwort !== "" and $passwort_wiederholen !== "") :
        $search_user = $db->prepare("SELECT email FROM users WHERE email = ?");
        $search_user->bind_param('s', $mail);
        $search_user->execute();
        $search_result = $search_user->get_result();
        if ($search_result->num_rows == 0) :
            $search_dcID = $db->prepare("SELECT discordId FROM users WHERE discordId = ?");
            $search_dcID->bind_param('s', $discordID);
            $search_dcID->execute();
            $search_result = $search_dcID->get_result();
            if ($search_result->num_rows == 0) :
                $passwort = md5($passwort);
                $eintrag_verzeichniss = $db->prepare("INSERT INTO users (vorname,nachname,email,discordId,password,dispo,pilot,created_at,lastLogin_at,verificationCode) VALUES (?,?,?,?,?,?,?,?,?,?)");
                $eintrag_verzeichniss->bind_param('sssisiiiii', $name, $nachname, $mail, $discordID, $passwort, $zero, $zero, $time, $leer, $leer);
                $eintrag_verzeichniss->execute();

                $search_user = $db->prepare("SELECT id FROM users WHERE email = ?");
                $search_user->bind_param('s', $mail);
                $search_user->execute();
                $search_result = $search_user->get_result();
                if ($search_result->num_rows == 1) :
                    $registrated_user = $search_result->fetch_object();
                    $response = '<div class="response_g">Account erfolgreich erstellt</div>';
                    $redirect = "Location: verify.php?id={$registrated_user->id}";
                    header($redirect);
                else :
                    $response = '<div class="response_ng">Es gab einen Fehler!</div>';
                endif;
            else :
                $response = '<div class="response_ng">DiscordID bereits registriert</div>';
            endif;
        else :
            $response = '<div class="response_ng">Mail bereits registriert</div>';
        endif;
    else :
        $response = '<div class="response_ng">Felder müssen ausgefüllt sein</div>';
    endif;
endif;
?> <html>

<head>
    <link href="\media\CSS\registrieren.css" rel="stylesheet">
    <title>Registrien</title>
</head>
<div class="box">
    <div class="heading">
        <h1>Registrieren</h1>
    </div>
    <div class="form">
        <form action="" method="post">
            <div class="outer"><input class="input-field" name="vorname" type="text" placeholder="Vorname" pattern="[^'\x22]+"></div>
            <div class="outer"><input class="input-field" name="nachname" type="text" placeholder="Nachname"></div>
            <div class="outer"><input class="input-field" name="mail" type="text" placeholder="E-Mail Addresse"></div>
            <div class="outer"><input class="input-field" name="discordID" type="text" placeholder="Discord ID" id="discordID"></div>
            <div class="help" id="help">1. ";;getID" in #bot eingeben<br>2. ID oben einfügen</div>
            <div class="outer"><input class="input-field" name="passwort" type="password" placeholder="Passwort"></div>
            <div class="outer"><input class="input-field" name="passwort_wiederholen" type="password" placeholder="Passwort"></div><input class="submit-btn" name="absenden" type="submit" value="REGISTRIEREN">
        </form>
    </div><a href="anmelden.php"><button class="an-btn">Anmelden</button></a> <?php echo $response; ?>
</div>

</html>
<script></script>