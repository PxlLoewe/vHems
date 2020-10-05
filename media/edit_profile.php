<?php
$db = new mysqli("185.248.140.14","Test","test","mysqlcshap");
if($db->connect_error){
    echo $db->connect_error;
}

$id = $user->id;
 
if(isset($_POST['submit'])) {
    if($_POST['pw1'] == "" or $_POST['pw2'] == "") {
    } elseif($_POST['pw1'] == $_POST['pw2']) {
        $pw = md5($_POST['pw1']);
        $stmt = $db->prepare("UPDATE users SET passwort = ? WHERE id = ?");
        $stmt->bind_param('si',$pw, $user->id);
        $stmt->execute();
    }
    $stmt = $db->prepare("UPDATE users SET uplay = ?, mail = ?, Nachricht = ? WHERE id = ?");
    $stmt->bind_param('sssi', $_POST['uplay'], $_POST['mail'], $_POST['nachricht'], $id);
    $stmt->execute();
  $response = "<div class='response_good'>Daten geändert!</div>";
}
$search_user = $db->prepare("SELECT * FROM users WHERE id = ?");
$search_user->bind_param('i',$id);
$search_user->execute();
$result_user = $search_user->get_result();
$user = $result_user->fetch_object();
?>

<html>
    <div class="box">
      <h3>Hier kannst du deine persönlichen Daten bearbeiten!</h1>
      <div class="info">
        <p>Deine ID: <?php echo $user->id ?></p>
        <p>Deine DiscordTag: <?php if($user->discordTag == "") { echo "Bitte verifiziere dein Account!"; } else { echo $user->discordTag; } ?></p>
      </div>
  <form method="post">
    <div class="outer"><input class="input-field" type="text" name="uplay" placeholder="" value="<?php echo $user->uplay; ?>"></div>
    <div class="outer"><input class="input-field" type="text" name="mail" placeholder="deine Mail Addresse" value="<?php echo $user->mail; ?>"></div>
    <div class="outer"><textarea class="input-field" id="nachricht" name="nachricht" maxLength="1000" placeholder="Deine Nachricht wird in deinem Profil angezeigt"><?php echo $user->Nachricht; ?></textarea></div>
    <div class="outer"><input class="input-field" placeholder="Dein Passwort (falls änderung)" type="password" name="pw1"></div>
    <div class="outer"><input class="input-field" type="password" placeholder="Passwort wiederholen (falls änderung)" name="pw2"></div>
    <input class="submit-btn" type="submit" name="submit" value="Speichern">
  </form>
 <?php echo $response; ?>
</div>
  <style>
    * {
      color: #fff;
    }
    input {
      background-color: #000;
    }
          *{
        font-family: sans-serif;
        margin: 0;
        padding: 0;
    }
    body{
        background-image: url(media/bg.jpg);
}
    .box{
      margin-top: 40px;
        width: 430px;
        padding: 20px;
        background-color: rgba(0, 0, 0, 0.61);
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
}
    h3 {
      text-align: center;
    }
    .input-field{
        margin: 0 auto;
        width: 100%;
        padding: 10px;
        height: 30px;
        background-color: rgb(12, 12, 12);
        border: dotted 2px rgb(45, 45, 45);
        outline: none;
        color: #fff;
        font-size: 20px;
        transition: all 200ms;
    }
    #nachricht {
      height: 200px;
      width: 100%;
      max-width: 100%;
      min-width: 100%;
      min-height: 200px;
      max-height: 400px;
    }
    .outer{
        margin-top: 20px;
        padding: 5px;
        border: solid 2px rgb(31, 67, 86);
    }
    .submit-btn{
        margin-top: 10px;
        width: 100%;
        height: 100px;
        background: linear-gradient(to bottom right, rgb(64, 156, 201), rgb(65, 160, 204));
        border: solid 2px rgb(255,255,255);
        color: #fff;
        font-size: 40px;
        font-family: Rainbow;
        transition: all 200ms;
    }
    .submit-btn:hover{
        cursor: pointer;
        border: solid 4px rgb(255,255,255);
    }
    .input-field:focus{
        border: dotted 2px rgb(255, 255, 255);
        padding: 20px;
    }
    .response{
        margin-top: 25px;
        color: rgb(255, 0, 0);
        text-align: center;
        }   
    .response_good{
        margin-top: 25px;
        color: rgb(0, 255, 98);
}
  </style>
</html>