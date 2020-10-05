<?php
$db = new mysqli("185.248.140.14","Test","test","mysqlcshap");
if($db->connect_error){
    echo $db->connect_error;
}
if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $password = $_POST["password"];
    if($_POST["name"] == "" or $_POST["passwort"]){
        $response = "Du musst alle Felder ausfüllen!";
    } else {
        $password = md5($password);
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param('ss',$name,$password);
        $stmt->execute();
        $login = $stmt->get_result();
        if($login->num_rows == 0){
            $response = "Daten Falsch!";
        } elseif($login->num_rows == 1){
            $login = $login->fetch_object();
            $_SESSION['userID'] = $login->id;
            $response = "Daten richtig";
            header('Location: index.php');

        }
    }
}
?>

<html>
    <form method="post" id="login" action="">
    
    <input class="input-field" type="text" name="name" placeholder="Nutzername">
    <input class="input-field" type="password" name="password" placeholder="Passwort">
    <input class="submit-btn" type="submit" value="LOGIN" name="submit">
    </form>
    <?php echo $response; ?>
    <a href="registrieren.php"><p>registrieren</p></a>
</html>