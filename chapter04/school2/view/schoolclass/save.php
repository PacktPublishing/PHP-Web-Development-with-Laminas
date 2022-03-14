<?php
use School\SchoolClass;
use School\SchoolClassTable;

require realpath(__DIR__ . '/../../vendor') .'/autoload.php';

$code = (int)($_POST['code'] ?? 0);
$name = ($_POST['name'] ?? '');

$model = new SchoolClass($code,$name);
$schoolClassTable = SchoolClassTable::getInstance();
$schoolClassTable->save($model);

header('Location: /view/schoolclass/index.php');