<?php
use School\SchoolClass;

require 'vendor/autoload.php';

$code = ($_POST['code'] ?? null);
$name = ($_POST['name'] ?? null);

$schoolClass = new SchoolClass((int)$code,$name);
$schoolClass->save();

header('Location: index.php');