<?php
// Detect if there was XHR request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	$fields = array('row', 'column', 'text');
	$sqlFields = array('name', 'age', 'location');

	foreach ($fields as $field) {
		if (!isset($_POST[$field]) || strlen($_POST[$field]) <= 0) {
			sendError('No correct data');
			exit();
		}
	}

	$db = new mysqli('localhost', 'root', '', 'grid');
	$db->set_charset('utf8');
	if ($db->connect_errno) {
		sendError('Connect error');
		exit();
	}

	$userQuery = sprintf("UPDATE user SET %s='%s' WHERE user_id=%d",
			$sqlFields[intval($_POST['column'])],
			$db->real_escape_string($_POST['text']),
			$db->real_escape_string(intval($_POST['row'])));
	$stmt = $db->query($userQuery);
	if (!$stmt) {
		sendError('Update failed');
		exit();
	}

}
header('Location: index.php');
function sendError($message) {
	header($_SERVER['SERVER_PROTOCOL'] .' 320 '. $message);
}