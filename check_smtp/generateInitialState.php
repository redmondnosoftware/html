<?php
require_once("defines.php");

// Generar estado inicial y declaracion de las plataformas
$plataforms["BO-SC-RBT-APP-2"]=PROBLEM;
//$plataforms["ESV-RBT-APP-2"]=PROBLEM;
$plataforms["HN-CC-APP-1"]=PROBLEM;;
$plataforms["BO-CC-APP-1"]=PROBLEM;
$plataforms["HN-RBT-APP-1"]=PROBLEM;
$plataforms["CO-CC-App-1"]=PROBLEM;
$plataforms["PY-4M-RBT-APP-2"]=PROBLEM;
//$plataforms["CC-PARAGUAY"]=PROBLEM;
$plataforms["GT-RBT-APPSERVER-5"]=PROBLEM;
$plataforms["GT-CC-PROXY-2"]=PROBLEM;
//$plataforms["CC-ELSALVADOR"]=PROBLEM;

file_put_contents("previous_state.json", json_encode( $plataforms ));    
