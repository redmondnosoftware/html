<?php
include_once("defines.php");

function purgeOldFiles(){
	$dir = opendir( PATH_STORE_REPORT );
	while($f = readdir($dir))
	{	 
		if((time()-filemtime( PATH_STORE_REPORT .$f) > 3600*24*15 ) and !(is_dir( PATH_STORE_REPORT .$f)))
		unlink( PATH_STORE_REPORT .$f);
	}
	closedir($dir);
}
?>