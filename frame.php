<?php
$db = new mysqli("185.248.140.14","Test","test","mysqlcshap");
if($db->connect_error){
    echo $db->connect_error;
}
$user_id = $_SESSION['userID'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param('i',$user_id);
$stmt->execute();
$user = $stmt->get_result();

if($user->num_rows == 0){
    session_destroy();
}else{
    $user = $user->fetch_object();
}
?>
<html>
<meta charset="utf-8">
<body>
    <div class="menue-bar">
        <h1 class="user"><?php echo strtoupper($user->vorname) ?></h1>
            <ul>
            <?php if($user->dispo == 1){
            echo "<li><a href='index.php?page=dispo'>DISPONIEREN</a></li>";
            } if($user->pilot == 1){
            echo "<li><a href='index.php?page=pilot'>PILOTIEREN</a></li>";
            } ?>
            <li><a href="index.php?page=edit_profile">Profil</a></li>
            <li><a href="index.php?page=logout">LOGOUT</a></li>
            </ul>
        </div>
</body>
<?php
    if(!isset($_GET['page'])){
        $_GET['page'] = "select";
    }
    require('subpages/' . $_GET['page'] . '.php');
?>
</div>
<style>
* {
    font-family: sans-serif;
    box-sizing: border-box;
    padding: 0;
    margin: 0;
}
    body {
        background-image: url(#);
        background-size: cover;
        }
    .menue-bar{
        width: 100%;
        height: 80px;
        background-color: rgb(0, 0, 0);
        font-family: sans-serif;
        align-content: center;
        transition: all 200ms;
    }    
    .user{
        position: absolute;
        padding: 3px;
        margin-top: 10px;
        color: rgb(255, 255, 255);
        margin: 20px 20px;
    }
    .menue-bar ul{
        width: auto;
        float: right;
        margin-top: 30px;
    }
    .menue-bar li{
        display: inline-block;   
    }
    .menue-bar a{
        text-align: center;
        color: rgb(255, 255, 255);
        text-decoration: none;
        font-family: Rainbow;
        font-size: 35px;
        margin: auto 15px;
    }
    .menue-bar a:hover{
        text-decoration: underline;
    }
    </style>
</html>