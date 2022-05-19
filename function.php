<?php

function sendComic($to, $subject, $message, $attachments = array())
{
	$headers   = array();
	$headers[] = "To: {$to}";
	$headers[] = 'From: Sambit Saha <sambit28saha@gmail.com>';
	$headers[] = 'X-Mailer: PHP/' . phpversion();

	$headers[] = 'MIME-Version: 1.0';

	if (!empty($attachments)) {
		$boundary  = md5(time());
		$headers[] = 'Content-type: multipart/mixed;boundary="' . $boundary . '"';
	} else {
		$headers[] = 'Content-type: text/html; charset=UTF-8';
	}
	$output   = array();
	$output[] = '--' . $boundary;
	$output[] = 'Content-type: text/html; charset="utf-8"';
	$output[] = 'Content-Transfer-Encoding: 8bit';
	$output[] = '';
	$output[] = $message;
	$output[] = '';
	foreach ($attachments as $attachment) {
		$output[] = '--' . $boundary;
		$output[] = 'Content-Type: ' . $attachment['type'] . '; name="' . $attachment['name'] . '";';
		if (isset($attachment['encoding'])) {
			$output[] = 'Content-Transfer-Encoding: ' . $attachment['encoding'];
		}
		$output[] = 'Content-Disposition: attachment;';
		$output[] = '';
		$output[] = $attachment['data'];
		$output[] = '';
	}
	mail($to, $subject, implode("\r\n", $output), implode("\r\n", $headers));
}
