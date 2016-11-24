<?php
// Define debbuging
define("IS_DEBBUG", false);

define("MAIL_USER", "redmondalarmsx@gmail.com");
define("MAIL_PWD", "Viamonte1621");
define("HOSTNAME", "{imap.gmail.com:993/imap/ssl}INBOX");
define("SUBJECT_KEY", "SMTP se encuentra funcionando correctamente." );

//Estado de las plataformas
define("PROBLEM", "0" );
define("OK", "1" );
define("RECOVERY", "2" );

define("SUBJECT_PROBLEM"," [PROBLEM] Chequeo de SMTP de la plataforma: CRITICAL");
define("SUBJECT_RECOVERY"," [RECOVERY] Chequeo de SMTP de la plataforma: RECOVERY");
define("BODY_INTRO","El servicio SMTP de la plataforma ");
define("BODY_PROBLEM"," no se encuentra funcionando, 
                 por lo que no llegar&aacute;n las notificaciones de Nagios del mismo. Esta alarma indica que al menos hace 2 horas no se reciben correos desde la plataforma<br/> 
                 Se debe notificar a Tigo de este error indicando que: si no funciona el servicio SMTP nuestro sistema de monitoreo 
                 no nos podr&aacute; notificar sobre fallas en la plataforma. <br/><br/>
		 ESTE CORREO NO ES UNA ALARMA DE NAGIOS, ES UN SCRIPT CRONEADO EN FLANDERS. EL CORREO NO TIENE HORARIO DE CHEQUEO 
		 Y FUNCIONA 24x7. <br/> EN CASO DE QUERER SILENCIARLO REALIZAR LOS SIGUIENTES PASOS:<br/>
		 Ingresar por ssh a FLANDERS(192.168.2.12), ir al archivo /var/www/html/check_smtp/check_smtp.php 
		 y comentar con doble barra la linea que corresponda del Array plataformCurrentState que se crea en la linea 8");

define("BODY_RECOVERY","Se ha restablecido el servicio SMTP, 
                          Si continuan llegando estas alarmas se debe notificar a Tigo del error indicando que: el servicio SMTP de nuestro sistema de monitoreo 
                          est&aacute; trabajando con demoras, y si no se resuelve, el SMTP no nos podr&aacute; notificar sobre fallas en la plataforma.");                 

// Defino a quienes se les envian los correos
$arrayOfAddress['facu'] = 'support@redmondsoftware.com';
?>
