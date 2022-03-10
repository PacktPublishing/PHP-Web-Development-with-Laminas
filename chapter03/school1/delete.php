<?php
use School\SchoolClass;

require 'vendor/autoload.php';

$code = ($_GET['code'] ?? null);

$schoolClass = SchoolClass::getByCode((int)$code);
$schoolClass->delete();

header('Location: index.php');