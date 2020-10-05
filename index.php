<?php

session_start();

if (isset($_SESSION['userID'])):
    
    require_once 'frame.php';
  else:
  require_once 'anmelden.php';
endif;
?>
