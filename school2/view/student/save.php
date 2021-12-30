<?php
use School\Student;
use School\StudentTable;

require realpath(__DIR__ . '/../../vendor') .'/autoload.php';

$id = (int)($_POST['id'] ?? 0);
$name = ($_POST['name'] ?? '');
$classCode = (int)($_POST['class_code'] ?? 0);

$model = new Student($id,$name,$classCode);
$studentTable = StudentTable::getInstance();
$studentTable->save($model);

header('Location: /view/student/index.php');