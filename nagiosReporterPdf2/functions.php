<?php 
include_once("defines.php");

/* gets the data from a URL */
function get_data($urlData) {	
	$OneMb = 1024 * 1024;
	$conectTimeout = 900;
	$timeout = 900;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL ,  $urlData );
	curl_setopt($ch, CURLOPT_FRESH_CONNECT,  true );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,  true );
	curl_setopt($ch, CURLOPT_BUFFERSIZE, $OneMb  );
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,  $conectTimeout );
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout );
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	@$html = curl_exec($ch);
	
	if ( IS_DEBBUG ){
		if(!curl_errno($ch)){ 
		  $info = curl_getinfo($ch); 
		  echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'] . ' <br><br> ' . $html ; 
		} else { 
		  echo 'Curl error: ' . curl_error($ch); 
		} 	
	}
	
	if(!curl_errno($ch))
		$result = $html;
	else	
		$result = null;
	
	curl_close($ch);
	return $result;	
}

//FUNCIONES QUE EJECUTAN LOS PROCESOS
function obtainReportFromNagios( $urlNagios , $newPage = true ){

	$html = get_data( $urlNagios . URL_FROM_REPORT );

	if ( !is_null($html) ){
		$isNagiosNotificationDisabled = stripos( $html , TEXT_NOTIFICATION_DISABLED  ) > 0;
	
		$html = substr( $html, strpos( $html, "<TABLE BORDER=0 CLASS='data'>") );
		$html = substr( $html, 0  , strrpos( $html, "</DIV>") );
		
		if( $isNagiosNotificationDisabled ){
			$html = "<div class='infoBoxBadProcStatus'>" . TEXT_NOTIFICATION_DISABLED . "</div><br><br>" . $html;
		}
		
		$html = replacePaths( $html , $urlNagios );
		$result = $html;
	} else {
		$result = "<h3>REPORTE NO GENERADO POR ERROR EN CONECTIVIDAD</h3>";
	}
	
	if(  $newPage ){
		$result .= newPage();
	}
	
	return $result;
}


function obtainCurrentStateFromNagios( $urlNagios , $newPage = true){

	$html = get_data( $urlNagios . URL_FROM_CURRENT_STATE);
	
	if ( !is_null($html) ){
	
		$isNagiosNotificationDisabled = stripos( $html , TEXT_NOTIFICATION_DISABLED  ) > 0;
	
		$html = substr( $html, strpos( $html, "<table border=0 width=100% class='status'>") );
		$html = substr( $html, 0  , strrpos( $html, "</div>") );
		
		if( $isNagiosNotificationDisabled ){
			$html = "<div class='infoBoxBadProcStatus'>" . TEXT_NOTIFICATION_DISABLED . "</div><br><br>" . $html;
		}
		
		$html = replacePaths( $html , $urlNagios );
		$result =  $html;
	} else {
		$result = "<h3>REPORTE NO GENERADO POR ERROR EN CONECTIVIDAD</h3>";
	}
	
	if(  $newPage ){
		$result .= newPage();
	}
	
	return $result;
}


function generateTitles( $title , $subtitle, $urlNagios){

	$result = "<a href='" . $urlNagios . "' target='_blank' ><h1>" . $title. "</h1></a> 
			   <span> " . $subtitle . " </span>
			   <br/><br/>";
			   
	return $result;
}

function generatePdf( $content , $filename ){
	
	logger("Generando Pdf de " . $filename  , "INFO");
	$dompdf = new DOMPDF();
	$dompdf->set_paper('A4', 'landscape');
	$dompdf->set_base_path( PATH_SCRIPT );
	$dompdf->load_html( $content );
	$dompdf->render();
	
	// a continuacion puede decidirse descargar el archivo en el cliente o almacenarlo
	//$dompdf->stream( FILENAME  );
	
	$pdf = $dompdf->output();
	file_put_contents( PATH_STORE_REPORT . $filename   , $pdf);
}

function generateStyle(){
	$html = "<html>
		     <head>
			 <link rel='stylesheet' type='text/css' href='" . PATH_SCRIPT . "style.css' />
			 </head>
	         <body>";
			 

	$html .=  "<div id='header'>
				<h2>Redmond Software - Reporte de alarmas semanal " . date("d/m/Y") ."</h2>
			  </div>
			  <div id='footer'>
				<p class='page'>Pag:  &nbsp;</a></p>
			  </div>";
			  
	return $html;
}

function endHtml(){
	$html = "</body>
			 </html>";
	
	return $html;
}

function newPage(){
	return "<p style='page-break-before: always'>&nbsp;</p>" ;
}

function replacePaths( $html , $urlNagios){
	$html = str_replace( '<a' , '<a target="_blank" ' , $html);
	$html = str_replace( 'extinfo.cgi' , $urlNagios . '/cgi-bin/extinfo.cgi' , $html);
	$html = str_replace( '/nagios/images/' , 'images/' , $html);
	
	return $html;
}

function generatePlataformReport( $arrayOfNagios , $filename ){
	$htmlFinally  = generateStyle();

	foreach ( $arrayOfNagios  as $key => $value){
		logger("Obteniendo datos de estadisticas de Nagios" .   $key . " : " . $value  , "INFO");
		$htmlFinally .= generateTitles( "Nagios " . $key , TEXT_SUBTITLE_REPORT  , $value);
		$htmlFinally .= obtainReportFromNagios( $value );
	}
	
	foreach ( $arrayOfNagios  as $key => $value){
		logger("Obteniendo datos de estado actual de Nagios" .   $key . " : " . $value  , "INFO");
		$htmlFinally .= generateTitles(  "Nagios " . $key , TEXT_SUBTITLE_CURRENT_STATE , $value );
		$htmlFinally .= obtainCurrentStateFromNagios (  $value , $value === end($arrayOfNagios)? FALSE : TRUE );
	}
	
	$htmlFinally .= endHtml();

	if( IS_DEBBUG ){
		echo $htmlFinally;
	} else {
		generatePdf( $htmlFinally , $filename );
	}
}

function logger($cadena,$tipo){
	$arch = fopen( PATH_STORE_REPORT . "log-" . date("Y-m-d") . ".txt", "a+"); 

	fwrite($arch, "[". date("Y-m-d H:i:s") . "][$tipo ] " . $cadena. "\n");
	fclose($arch);
}

?>