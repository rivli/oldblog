<?php
session_start();
/**
*		.	.	.
*/
if( isset($_POST['width']) && isset($_POST['height']) ){
$_SESSION['screenWidth']	=	$_POST['width'] ;
$_SESSION['screenHeight']	=	$_POST['height'] ;
}
 ?>
