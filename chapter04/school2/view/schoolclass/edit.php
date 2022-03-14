<?php
use School\SchoolClassTable;

require realpath(__DIR__ . '/../../vendor') .'/autoload.php';

$code = $_GET['code'] ?? null;

$schoolClass = SchoolClassTable::getInstance()->getByField('code',$code);
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
<a href="index.php">Go back</a>
</p>
</body>
</html>