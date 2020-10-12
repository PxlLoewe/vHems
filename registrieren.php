<?php
$db = new mysqli("185.248.140.14","Test","test","mysqlcshap");
if($db->connect_error){
    echo $db->connect_error;
}

if(isset($_POST['absenden'])):

  $name = $_POST['vorname'];
  $nachname = $_POST['nachname'];
  $discordID = $_POST['discordID'];
  $mail = $_POST['mail'];
  $passwort = $_POST['passwort'];
  $passwort_wiederholen = $_POST['passwort_wiederholen'];
  $zero = "0"; 
  $leer = "";
  $time = time();

  if($name == "" or $uplay == "" or $mail == "" or $passwort == "" or $passwort_wiederholen == ""):
    $search_user = $db->prepare("SELECT email FROM users WHERE email = ?");
    $search_user->bind_param('s',$mail);
    $search_user->execute();
    $search_result = $search_user->get_result();
    if ($search_result->num_rows == 0):
        $passwort = md5($passwort);
        $eintrag_verzeichniss = $db->prepare("INSERT INTO users (vorname,nachname,email,discordId,password,dispo,pilot,created_at,lastLogin_at) VALUES (?,?,?,?,?,?,?,?,?)");
        $eintrag_verzeichniss->bind_param('sssisiiii',$name,$nachname,$mail,$discordID,$passwort,$zero,$zero,$time,$leer);
        $eintrag_verzeichniss->execute();
            if($insert !== false):
            $response_good = "Account erfolgreich erstellt!<br>";
            endif;
        else:
        $response = 'Mail bereits registriert!';
        endif;
        else:
            $response = 'Passwörter stimmen nicht überein!';
    endif;
endif;
?>
<html>
    <div class="box">
            <div class="form">
                <form action="" method="post">
                <div class="outer"><input class="input-field" type="text" name="vorname" pattern="[^'\x22]+" placeholder="Vorname"></div><br>
                <div class="outer"><input class="input-field" type="text" name="nachname" placeholder="Nachname"></div><br>
                <div class="outer"><input class="input-field" type="text" name="mail" placeholder="E-Mail Addresse"></div><br>
                <div class="outer"><input class="input-field" type="text" name="discordID" placeholder="Discord ID"></div><br>
                <div class="outer"><input class="input-field" type="password" name="passwort" placeholder="Passwort"></div><br>
                <div class="outer"><input class="input-field" type="password" name="passwort_wiederholen" placeholder="Passwort"></div><br>
                <input class="submit-btn" type="submit" name="absenden" value="REGISTRIEREN"><br>
                <div class="response"><?php echo $response; ?></div>
                <div class="response_good"><?php echo $response_good; ?></div>
                </form>
            </div>
            <p><a href="anmelden.php">Anmelden</a></p>
    </div>
</html>