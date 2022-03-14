<?php
use School\SchoolClass;
use School\StudentTable;
use School\SchoolClassTable;

require realpath(__DIR__ . '/../../vendor') .'/autoload.php';

$id = $_GET['id'] ?? null;

$student = StudentTable::getInstance()->getByField('id',$id);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Students Registration</title>
</head>
<body>
<h1>Students Registration</h1>
<form action="save.php" method="post">
Name: <input type="text" name="name" autofocus="autofocus" value="<?=$student->name?>">
<select name="class_code">
<?php
$schoolClasses = SchoolClassTable::getInstance()->getAll();
foreach($schoolClasses as $schoolClass):
?>
<option value="<?=$schoolClass->code?>" <?=($schoolClass->code == $student->schoolClass->code ? 'selected="selected"' : '')?>><?=$schoolClass->name?></option>
<?php    
endforeach;
?>
</select>
<input type="hidden" name="id" value="<?=$student->id?>"><br/>
<input type="submit" value="save">
</form>
<p>
<a href="index.php">Go back</a>
</p>
</body>
</html>