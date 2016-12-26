<?php
/*
 * 
 */
namespace Raiz\Calculator;

use \Raiz\RPN\{
    Operator,
    ExpressionString
};

/**
 * 
 */
class Calculator
{

    private $operators = [];

    /*
     * 
     */

    public function __construct()
    {
        $this->setOperator('+', [Operator::ATTR_CALLBACK => function($i, $j) {
                    return $i + $j;
                }])
            ->setOperator('-', [Operator::ATTR_CALLBACK => function($i, $j) {
                    return $i - $j;
                }])
            ->setOperator('*', [Operator::ATTR_CALLBACK => function($i, $j) {
                    return $i * $j;
                }])
            ->setOperator('%', [Operator::ATTR_CALLBACK => function($i, $j) {
                    return $i % $j;
                }])
            ->setOperator('/', [Operator::ATTR_CALLBACK => function($i, $j) {
                    return $i / $j;
                }])
            ->setOperator('^', [Operator::ATTR_CALLBACK => function($i, $j) {
                    return $i ** $j;
                }]);
    }
    /*
     * 
     */

    public function calcExpression(string $str = ''): int
    {
        $expression = new ExpressionString($str, $this->operators);
        return $expression->calculate();
    }
    /*
     * 
     */

    public function setOperator(string $operator, array $options = []): self
    {
        if (empty($this->operators[$operator])) {
            $this->operators[$operator] = new Operator($operator);
        };
        $this->operators[$operator]->setOptions($options);
        return $this;
    }
}
