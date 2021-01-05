<?php

$db = new mysqli("localhost", "login", "Ighids11", "vHEMS");
if ($db->connect_error) {
    echo $db->connect_error;
}$res = $db->query("SELECT * FROM `Website-settings` WHERE `menuPunkt` = 'on' AND `wert` = '1'");
$online = $res->num_rows;

if($online == 1){

session_start();

if (isset($_SESSION['userID'])):
    
    require_once 'frame.php';
  else:
  require_once 'anmelden.php';
endif;
} else {
  ?> 
  <style>
    body {
      background-color:  #10161f;
    }
    h1 {
      margin: auto;
      width: 80%;
      height: 20%;
      font-family: sans-serif;
      text-align: center;
      color: #fff;
    }
  </style>
  <body>
    <h1>Die Seite ist momentan noch in der Entwicklung und ist daher nur online, wenn an ihr gearbeitet Wird! <br><br> GZ, Johannes</h1>
  </body>
  <?php
}
?>