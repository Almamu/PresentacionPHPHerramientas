<?php
	require "../vendor/autoload.php";

	$_SERVER ['REQUEST_METHOD'] === 'POST' or die ();
	array_key_exists ('type', $_POST) === false or die ();
	array_key_exists ('service', $_POST) === false or die ();
	array_key_exists ('message', $_POST) === false or die ();
	
	$logger = new Logger ();
	
	switch (true)
	{
		case $_POST ['type'] == 'debug':
			$logger->debug ($_POST ['service'], $_POST ['message']);
			break;
		case $_POST ['type'] == 'error':
			$logger->debug ($_POST ['service'], $_POST ['message']);
			break;
		case $_POST ['type'] == 'warning':
			$logger->debug ($_POST ['service'], $_POST ['message']);
			break;
		case $_POST ['type'] == 'info':
			$logger->debug ($_POST ['service'], $_POST ['message']);
			break;
	}

	$logger->save ();