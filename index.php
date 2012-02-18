<?php
$db = new mysqli('localhost', 'root', '', 'grid');
$db->set_charset('utf8');
if ($db->connect_errno) {
	die('Check the database connection again!');
}

$userQuery = 'SELECT user_id, name, age, location FROM user';
$stmt = $db->query($userQuery);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				var textBefore = '';
				$('#grid').find('td input').hover(function() {
					textBefore = $(this).val();
					$(this).focus();
				}, function() {
					var $field = $(this),
						text = $field.val();
					$(this).blur();
					// Set back previous value if empty
					if (text.length <= 0) {
						$field.html(textBefore);
					} else if (textBefore !== text) {
						// Text has been changed make query
						var value = {
							'row': parseInt(getRowData($field)),
							'column': parseInt($field.closest('tr').children().find(':input').index(this)),
							'text': text
						};
						$.post('user.php', value)
						.error(function() {
							$('#message')
								.html('Make sure you inserted correct data')
								.fadeOut(3000)
								.html('&nbsp');
							$field.val(textBefore);
						})
						.success(function() {
							$field.val(text);
						});
					} else {
						$field.val(text);
					}

				});

				// Get the id number from row
				function getRowData($td) {
					return $td.closest('tr').prop('class').match(/\d+/)[0];
				}
			});
		</script>
		<title></title>
    </head>
    <body>
	<?php if ($stmt): ?>
	<div id="grid">
	<p id="message">Click on the field to edit data</p>
	<table>
		<thead>
			<tr>
				<th>Name</th>
				<th>Age</th>
				<th>From</th>
			</tr>
		</thead>
		<tbody>
		<?php while ($row = $stmt->fetch_assoc()): ?>
			<tr class="<?php echo $row['user_id']; ?>">
				<td><input type="text" value="<?php echo $row['name']; ?>" /></td>
				<td><input type="text" value="<?php echo $row['age']; ?>" /></td>
				<td><input type="text" value="<?php echo $row['location']; ?>" /></td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
	</div>
	<?php else: ?>
		<p>No users added yet</p>
	<?php endif; ?>
    </body>
</html>
