<?php
//The URL that we want to GET.
$url = "http://localhost:8080/api/scrollIcon?ip={$_GET['ip']}";
//Use file_get_contents to GET the URL in question.
header("HTTP/1.1 200 OK");

file_get_contents($url);


//If $contents is not a boolean FALSE value.
//if($contents !== false){
//    //Print out the contents.
//    echo $contents;
//}