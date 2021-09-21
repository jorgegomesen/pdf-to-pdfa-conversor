<?php
header('Set-Cookie: fileDownload=true; path=/');
header('Cache-Control: max-age=60, must-revalidate');
header("Content-type: application/pdf");
header('Content-Disposition: attachment; filename="'. basename($_GET['filename']) .'"');

try{
	$page = file_get_contents('uploads/'.$_GET['filename']);
	echo $page;
	header('Set-Cookie: fileDownload=true; path=/');
}catch(Exception $e){
	header('Set-Cookie: fileDownload=false; path=/');	
}

exit();