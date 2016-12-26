<?php
require dirname(__DIR__) . '/lib/vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
    ]);



function render($response, string $file, array $args = [])
{
    $loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/template');
    $twig = new Twig_Environment($loader);
    $response->write($twig->render($file, $args));
}




$app->get('/', function ( $request, $response) {
    render($response, 'layout.html');
});





$app->get('/calculator', function ( $request, $response) {

    $equation = $request->getQueryParam('equation');

    if (!$equation) {
        return;
    }

    $calculator = new \Raiz\Calculator\Calculator;

    $result = $calculator
        ->setOperator('*', ['precedence' => 1])
        ->setOperator('%', ['precedence' => 1])
        ->setOperator('/', ['precedence' => 1])
        ->setOperator('^', ['precedence' => 1])
        ->calcExpression($equation);

    return $response->withJson([
            'value' => $result,
            'success' => 1]);
});





$app->run();
