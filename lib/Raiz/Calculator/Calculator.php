<?php
/*
 * 
 */
namespace Raiz\Calculator;

use \Raiz\RPN\{
    Operators,
    ExpressionString
};

/**
 * 
 */
class Calculator
{

    private $rpnOperators;

    /*
     * 
     */

    public function __construct()
    {
        $this->rpnOperators = new Operators;
    }
    /*
     * 
     */

    public function calcExpression(string $str = ''): int
    {
        $expression = new ExpressionString($str, $this->rpnOperators);
        return $expression->calculate();
    }
    /*
     * 
     */

    public function setOperator(string $operator, array $options = [], callable $callback = null): Calculator
    {
        $this->rpnOperators->setOperator($operator, $options, $callback);
        return $this;
    }
}
