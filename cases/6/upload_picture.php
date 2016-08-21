<?php 
	$tmp_name = $_FILES["file"]["tmp_name"];
	$name = $_FILES["file"]["name"];
	move_uploaded_file($tmp_name, "images/$name");
?>