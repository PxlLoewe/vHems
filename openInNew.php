<?php 

$requiredPage = $_GET["form"];

if ($requiredPage == "melder"):
    
    require_once './subpages/melder.php';
  else:
  require_once 'index.php';
endif;

?>