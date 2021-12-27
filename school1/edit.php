<?php
use School\SchoolClass;

require 'vendor/autoload.php';

$code = ($_GET['code'] ?? null);

$schoolClass = SchoolClass::getByCode($code);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Classes Registration</title>
</head>
<body>
<h1>Classes Registration</h1>
<form action="save.php" method="post">
Name: <input type="text" name="name" autofocus="autofocus" value="<?=$schoolClass->name?>"><br/>
<input type="hidden" name="code" value="<?=$schoolClass->code?>"><br/>
<input type="submit" value="save">
</form>
<p>
<a href="index.php">Homepage</a>
</p>
</body>
</html>