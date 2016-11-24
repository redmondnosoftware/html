<?php
require_once("dompdf/dompdf_config.inc.php");
require_once("defines.php");
require_once("functions.php");
require_once("mailer.php");
require_once("purgeOldFiles.php");

logger("Iniciando proceso..." , "INFO");

logger("Generando reporte RBT..." , "INFO");
generatePlataformReport( $urlNagiosRBT, FILENAME_RBT );

logger("Generando reporte CC..." , "INFO");
generatePlataformReport( $urlNagiosCC, FILENAME_CC );

logger("Enviando correo electronico..." , "INFO");
sendMail( $arrayOfAddress );

logger("Purgando archivos antiguos..." , "INFO");
purgeOldFiles();

logger("proceso finalizado" , "INFO");
?>