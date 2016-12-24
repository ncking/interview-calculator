<?php

require dirname(__DIR__) . '/lib/vendor/autoload.php';

$str = $_GET['equation'] ?? '';
$calculator = new \Raiz\Calculator\Calculator;

$value = $calculator
    ->setOperator('*', ['precedence' => 1])
    ->setOperator('%', ['precedence' => 1])
    ->setOperator('/', ['precedence' => 1])
    ->setOperator('^', ['precedence' => 1])
    ->calcExpression($str);

$value = [
    'value' => $value,
    'success' => 1];

$response = new \Raiz\HTTP\Response\JsonResponse();
$response->setExpires(0)->send($value);
