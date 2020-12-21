<!DOCTYPE html>
<html>
<link href="/subpages/css/editProfile.css" rel="stylesheet">

</html>

<?php
$db = new mysqli("localhost", "login", "Ighids11", "vHEMS");
if ($db->connect_error) {
    echo $db->connect_error;
}

if (isset($_POST['absenden'])) :

    $name = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $mail = $_POST['mail'];
    $passwort = $_POST['passwort'];
    $passwort_wiederholen = $_POST['passwort_wiederholen'];
    $userID = $_SESSION['userID'];

    if ($name !== "" and $nachname !== "" and $mail !== "") :
        $search_user = $db->prepare("SELECT email FROM users WHERE email = ?");
        $search_user->bind_param('s', $mail);
        $search_user->execute();
        $search_result = $search_user->get_result();
        if ($search_result->num_rows == 1) :
            if ($passwort != "" and $passwort_wiederholen != "" and $passwort) :

                $passwort = md5($passwort);
                $eintrag_verzeichniss = $db->prepare("UPDATE users SET vorname = ?, nachname = ? ,email = ?, password = ? WHERE id = ?");
                $eintrag_verzeichniss->bind_param('ssssi', $name, $nachname, $mail, $passwort, $userID);
                $eintrag_verzeichniss->execute();
                $response = '<div class="response_g">Änderungen übernommen</div>';

            else :
                $passwort = md5($passwort);
                $eintrag_verzeichniss = $db->prepare("UPDATE users SET vorname = ?, nachname = ? ,email = ? WHERE id = ?");
                $eintrag_verzeichniss->bind_param('sssi', $name, $nachname, $mail, $userID);
                $eintrag_verzeichniss->execute();
                $response = '<div class="response_g">Änderungen übernommen</div>';
            endif;
        else :
            $response = '<div class="response_ng">Mail bereits registriert</div>';
        endif;
    else :
        $response = '<div class="response_ng">Felder müssen ausgefüllt sein</div>';
    endif;
endif;

$ID = $_SESSION['userID'];

$search_user = $db->prepare("SELECT * FROM users WHERE id = ?");
$search_user->bind_param('i', $ID);
$search_user->execute();
$result_user = $search_user->get_result();
$user = $result_user->fetch_object();

?> <html>

<head>
    <link href="\media\CSS\registrieren.css" rel="stylesheet">
    <title>Registrien</title>
</head>
<div class="box">
    <div class="heading">
        <h1>Dein Profil</h1>
    </div>
    <div class="form">
        <form action="" autocomplete="off" method="post">
            <div class="outer"><input class="input-field" name="vorname" value="<?php echo($user->vorname); ?>" type="text" placeholder="Vorname" pattern="[^'\x22]+"></div>
            <div class="outer"><input class="input-field" name="nachname" value="<?php echo($user->nachname); ?>" type="text" placeholder="Nachname"></div>
            <div class="outer"><input class="input-field" name="mail" value="<?php echo($user->email); ?>" type="text" placeholder="E-Mail Addresse"></div>
            <div class="outer"><input class="input-field" name="passwort"  type="password" placeholder="Passwort"></div>
            <div class="outer"><input class="input-field" name="passwort_wiederholen"  type="password" placeholder="Passwort"></div><input class="submit-btn" name="absenden" type="submit" value="ABSENDEN">
        </form> 
        <?php echo $response; ?>
</div>

</html>
<script></script>