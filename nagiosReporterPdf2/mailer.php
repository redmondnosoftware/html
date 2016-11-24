<?php
require_once("PHPMailer/PHPMailerAutoload.php");
include_once("defines.php");

function sendMail( $arrayOfAddress ){
	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

	$mail->IsSMTP(); // telling the class to use SMTP

	try {

		if( IS_DEBBUG )
			$mail->SMTPDebug  = 2;                      // enables SMTP debug information (for testing)
		else
			$mail->SMTPDebug  = 0;   

		$mail->SMTPAuth   = true;                       // enable SMTP authentication
		$mail->SMTPSecure = "tls";                      // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";           // sets GMAIL as the SMTP server
		$mail->Port       = 587;                        // set the SMTP port for the GMAIL server
		$mail->Username   = MAIL_USER;                  // GMAIL username
		$mail->Password   = MAIL_PWD;                   // GMAIL password
		$mail->SetFrom( MAIL_USER, '');

		foreach ( $arrayOfAddress as $address){
			$mail->AddAddress( $address , ' ');
		}
		
		$mail->Subject = "Redmond Software - Reporte de alarmas semanal " . date("d/m/Y")  ;
		$mail->MsgHTML("Reporte semanal de alarmas");
		$mail->AddAttachment( PATH_STORE_REPORT . FILENAME_RBT );            // attachment
		$mail->AddAttachment( PATH_STORE_REPORT . FILENAME_CC );             // attachment
		$mail->Send();

		if( IS_DEBBUG )
		echo "Mensaje enviado correctamente\n";

	} catch (phpmailerException $e) {
	  echo $e->errorMessage(); //Pretty error messages from PHPMailer
	  
	} catch (Exception $e) {
	  echo $e->getMessage(); //Boring error messages from anything else!
	}
}
?>