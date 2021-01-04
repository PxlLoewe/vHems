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
}