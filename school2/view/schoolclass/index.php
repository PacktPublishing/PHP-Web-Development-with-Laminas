<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Classes Registration</title>
</head>
<body>
	<h1>Classes Registration</h1>
	<p>
		<a href="/view/schoolclass/edit.php">Add a new class</a>
	</p>
	<table>
		<thead>
			<tr>
				<th>code</th>
				<th>name</th>
			</tr>
		</thead>
		<tbody>
<?php
require 'list.php';
?>
		</tbody>
	</table>
	<p><a href="/index.php">Homepage</a></p>
</body>
</html>