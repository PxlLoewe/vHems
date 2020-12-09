<?php 

if(!isset($_GET['form'])){
  $_GET['form'] = "melder";
}
require('subpages/' . $_GET['form'] . '.php');
