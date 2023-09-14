<?php
session_start();
require_once 'vendor/autoload.php';
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QROutputInterface;
if(!isset($_SESSION['qr_token'])) {
	http_response_code(400);
	die();
}
try {
	$options = new QROptions;
	$options->outputType = QROutputInterface::GDIMAGE_PNG;
	$options->scale = 6;
	$options->imageTransparent = false;
	$qr = (new QRCode($options))->render(base64_decode($_SESSION['qr_token']));
	header("Content-Type: image/png");
	echo base64_decode(substr($qr,22));
} catch (Exception $e) {
	http_response_code(500);
}