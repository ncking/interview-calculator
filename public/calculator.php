<?php
require dirname(__DIR__) . '/lib/vendor/autoload.php';

$str = $_GET['equation'] ?? '';
$calculator = new \Raiz\Calculator\Calculator;

$result = $calculator
    ->setOperator('*', ['precedence' => 1])
    ->setOperator('%', ['precedence' => 1])
    ->setOperator('/', ['precedence' => 1])
    ->setOperator('^', ['precedence' => 1])
    ->calcExpression($str);


$response = new \Raiz\HTTP\Response\JsonResponse();

$response->setExpires(0)->send([
    'value' => $result,
    'success' => 1]);
