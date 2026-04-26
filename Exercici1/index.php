<?php
include 'Exceptions.php';
error_reporting(E_ALL);

$num1 = 5;
$num2 = 0;

try {
    echo (float) $num1 / $num2;
} catch (DivisionByZeroError $e) {
    $e = DivbyZeroException::error($num2);
    echo $e->getMessage();
}
