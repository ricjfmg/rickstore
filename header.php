<?php
require_once('conf.php');
#var_dump($_SESSION);
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8">
	<title>Rickstore <?=$page_name?></title>
	<link rel="stylesheet" href="style.css">
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
	<div id='wrapper'>
		<div id='header'>
			<?php include('menu.php'); ?>
		</div>
		<div id='main'>
			<div id='load'>