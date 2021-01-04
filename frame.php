<?php
$db = new mysqli("localhost", "login", "Ighids11", "vHEMS");
if ($db->connect_error) {
    echo $db->connect_error;
}
$user_id = $_SESSION['userID'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user = $stmt->get_result();

$res = $db->query("SELECT * FROM `Website-settings` WHERE `menuPunkt` = 'Werbung' AND `wert` = '1'");
$add = $res->num_rows;

if ($user->num_rows == 0) {
    session_destroy();
} else {
    $user = $user->fetch_object();
}?>

<html>


<head>
    <meta charset="utf-8">
    <link href="\media\CSS\frame.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">

</head>

<body>
    <div class="menue-bar">
        <h1 class="user"><?php echo strtoupper($user->vorname) ?></h1>
        <ul> <?php if ($user->dispo == 1) {
                    echo "<li><a href='index.php?page=dispo'>Dispo</a></li>";
                }
                if ($user->pilot == 1) {
                    echo "<li><a href='index.php?page=pilot'>Pilot</a></li>";
                } ?> <li><a href="index.php?page=edit_profile">Profil</a></li>
            <li><a class="red" href="index.php?page=logout">Logout</a></li>
        </ul>
    </div>
</body> <?php
        if (!isset($_GET['page'])) {
            $_GET['page'] = "select";
        }
        require('subpages/' . $_GET['page'] . '.php');
        ?>

</html>