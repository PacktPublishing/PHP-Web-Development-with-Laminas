<?php
use School\Student;
use School\StudentTable;

require realpath(__DIR__ . '/../../vendor') .'/autoload.php';

$id = ($_GET['id'] ?? null);

$studentTable = StudentTable::getInstance();
$studentTable->delete($id);

header('Location: /view/student/index.php');