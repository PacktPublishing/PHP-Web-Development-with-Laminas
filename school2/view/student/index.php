<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Students Registration</title>
</head>
<body>
	<h1>Students Registration</h1>
	<p>
		<a href="/view/student/edit.php">Add a new student</a>
	</p>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>name</th>
				<th>class</th>
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