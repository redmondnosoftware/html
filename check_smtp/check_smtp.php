<?php 
require_once("defines.php");
require_once("mailer.php");

echo "<h2>Comienzo</h2>";

// Cargo estado inicial de chequeo
$plataformCurrentState["BO-SC-RBT-APP-2"]=false;
$plataformCurrentState["BO-CC-APP-1"]=false;
//$plataformCurrentState["ESV-RBT-APP-2"]=false;
$plataformCurrentState["PY-4M-RBT-APP-2"]=false;
$plataformCurrentState["CC-PARAGUAY"]=false;
$plataformCurrentState["HN-CC-APP-1"]=false; 
$plataformCurrentState["HN-RBT-APP-1"]=false;
//$plataformCurrentState["CO-CC-App-1"]=false;
$plataformCurrentState["GT-RBT-APPSERVER-5"]=false;
$plataformCurrentState["GT-CC-PROXY-2"]=false;


/* Inicio conexion */
$inbox = imap_open( HOSTNAME, MAIL_USER , MAIL_PWD ) or die('Cannot connect to Gmail: ' . imap_last_error());

/* Obtengo correos */
$emails = imap_search($inbox, 'UNSEEN SUBJECT "'. SUBJECT_KEY .'"' );  

if( $emails !== FALSE ) {
	foreach($emails as $email_number) {
		// Obtengo info de cada correo
		$overview = imap_fetch_overview($inbox,$email_number,0);
		$message = imap_fetchbody($inbox,$email_number,1);
		
        //Se marca que plataformas enviaron correos
        foreach( $plataformCurrentState as $plataformKey => $plataformValue ){
            if(  strpos($message,$plataformKey) !== false ){
               $plataformCurrentState[$plataformKey] = true;
            }
        }
    }
} 

/* Cierre de conexion */
imap_close($inbox);

echo "<h3>Fin lectura de correos...</h3>";

$plataformPreviousState = json_decode(file_get_contents("previous_state.json"), true);
$plataformNextState = $plataformPreviousState;


echo "<h2>Resultados obtenidos</h2>";
foreach( $plataformCurrentState as $plataformKey => $plataformValue ){
    
    // Si no llegó el correo es un PROBLEM
    if( !$plataformValue ){
        if (date('HH:mm') >= '08:00' && date('HH:mm') <= '23:59'){ 
        //Notifico PROBLEM
        	echo  "$plataformKey [PROBLEM] Chequeo de SMTP de la plataforma: CRITICAL <br/>";    
	        sendMail( $arrayOfAddress , $plataformKey . SUBJECT_PROBLEM , BODY_INTRO . $plataformKey .  BODY_PROBLEM );
        	$plataformNextState[$plataformKey] = PROBLEM;
	}
       
    // Si llego y antes era un problema, ahora es recovery 
    } else if ($plataformPreviousState[$plataformKey] == PROBLEM){
         
        //Notifico RECOVERY
        echo  "$plataformKey [RECOVERY] Chequeo de SMTP de la plataforma: RECOVERY <br/>";    
        sendMail( $arrayOfAddress , $plataformKey . SUBJECT_RECOVERY , BODY_INTRO . $plataformKey .  BODY_RECOVERY );
         $plataformNextState[$plataformKey] = OK;
     
    // Si es OK
    } else
        echo  "$plataformKey [OK] Chequeo de SMTP de la plataforma: OK <br/>";
    }

file_put_contents("previous_state.json", json_encode( $plataformNextState ));    
