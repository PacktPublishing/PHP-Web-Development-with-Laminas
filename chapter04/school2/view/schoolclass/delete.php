<?php
use School\SchoolClassTable;

require realpath(__DIR__ . '/../../vendor') .'/autoload.php';

$code = ($_GET['code'] ?? null);

$schoolClassTable = SchoolClassTable::getInstance();
$schoolClassTable->delete($code);

header('Location: /view/schoolclass/index.php');