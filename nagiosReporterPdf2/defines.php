<?php
// Aumento el tiempo de timeout
ini_set('default_socket_timeout', 900);
ini_set('max_execution_time', 900);
ini_set("memory_limit",-1);

//Define debbuging
define("IS_DEBBUG", false);

//DECLARO VARIABLES NECESARIAS
define("URL_FROM_REPORT", "/cgi-bin/summary.cgi?report=1&displaytype=3&timeperiod=last7days&smon=12&sday=1&syear=2014&shour=0&smin=0&ssec=0&emon=12&eday=2&eyear=2014&ehour=24&emin=0&esec=0&hostgroup=all&servicegroup=all&host=all&alerttypes=3&statetypes=2&hoststates=3&servicestates=56&limit=20");
define("URL_FROM_CURRENT_STATE",  "/cgi-bin/status.cgi?host=all&servicestatustypes=28&limit=100");
define("URL_AUX_NAGIOS", "http://redmond:Viamonte1621@");
define("TEXT_NOTIFICATION_DISABLED", 'Notifications are disabled');
define("PATH_STORE_REPORT", "/var/www/html/nagiosReporterPdf/reportsGenerated/");
define("PATH_SCRIPT", "/var/www/html/nagiosReporterPdf/");

//Defino subtitulos 
define("TEXT_SUBTITLE_REPORT", "El siguiente informe muestra las 20 alarmas que mayor cantidad de veces sonaron en los &uacute;ltimos siete d&iacute;as");
define("TEXT_SUBTITLE_CURRENT_STATE", "El siguiente cuadro muestra las alarmas activas al d&iacute;a de hoy");

//Defino nombres de archivos
define("FILENAME_RBT", "ReporteNagiosRBT-" . date("Y-m-d")  . ".pdf" );
define("FILENAME_CC", "ReporteNagiosCC-" . date("Y-m-d")  . ".pdf" );

// ---------------------------------- Nagios URLs -----------------------------------

//Defino URL de Nagios
$urlNagiosRBT["RBT-GT"]  = URL_AUX_NAGIOS . "172.22.43.4/nagios" ;
$urlNagiosRBT["RBT-ESV"] = URL_AUX_NAGIOS . "192.168.226.31/nagios" ;
$urlNagiosRBT["RBT-BO"]  = URL_AUX_NAGIOS . "172.16.63.31/nagios" ;
$urlNagiosRBT["RBT-HO"]  = URL_AUX_NAGIOS . "192.168.204.47/nagios" ;
$urlNagiosRBT["RBT-PY"]  = URL_AUX_NAGIOS . "10.32.3.13/nagios" ;
$urlNagiosRBT["RBT-Algar-BR"]  = URL_AUX_NAGIOS . "10.99.0.75:8120/nagios" ;
$urlNagiosRBT["RBT-Antel-UY"]  = URL_AUX_NAGIOS . "10.64.84.4/nagios" ;
$urlNagiosRBT["RBT-CW-PA"]  = URL_AUX_NAGIOS . "172.29.1.39/nagios" ;
$urlNagiosRBT["RBT-Personal-PY"]  = URL_AUX_NAGIOS . "10.129.6.10/nagios" ;

$urlNagiosCC["CC-GT"]  = "https://redmond:Viamonte1621@172.22.46.11/nagios" ;
$urlNagiosCC["CC-ESV"] = URL_AUX_NAGIOS . "192.168.226.106/nagios" ;
$urlNagiosCC["CC-BO"]  = URL_AUX_NAGIOS . "172.16.63.197/nagios" ;
$urlNagiosCC["CC-CO"]  = URL_AUX_NAGIOS . "10.11.2.16/nagios" ;
$urlNagiosCC["CC-PY"]  = "https://redmond:Viamonte1621@10.32.3.22/nagios" ;
//$urlNagiosCC["RAFA"]  = "http://redmond:Viamonte1621@192.168.2.152:81/nagios/" ;
$urlNagiosCC["VM-Entel-BO"]  = URL_AUX_NAGIOS . "10.191.170.102/nagios" ;

// -------------------------------------- MAIL -------------------------------------
define("MAIL_USER", "redmondalarms@gmail.com");
define("MAIL_PWD", "Viamonte1621");

//Defino a quienes se les envian los correos
//Nagios 
$arrayOfAddress['juanPablo'] = 'juanpablo.baserga@redmondsoftware.com';
$arrayOfAddress['francisco'] = 'francisco.dipardo@redmondsoftware.com';


//PM
$arrayOfAddress['nico']  = 'nicolas.salvanes@redmondsoftware.com';
$arrayOfAddress['pablo'] = 'pablo.ubal@redmondsoftware.com';
$arrayOfAddress['diego'] = 'diego.barberio@redmondsoftware.com ';
$arrayOfAddress['jose']  = 'jose.giuffrida@redmondsoftware.com';


?>
