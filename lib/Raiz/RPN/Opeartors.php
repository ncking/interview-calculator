<?php
/*
 * 
 */
namespace Raiz\RPN;

class Operators
{

    const ATTR_ASSOCIATIVITY = 'associativity';
    const ATTR_PRECEDENCE = 'precedence';
    const ATTR_CALLBACK = 'callback';

    /*
     * 
     */

    private $operators = [];
    /*
     * 
     */
    private $operatorDefaults = [
        self::ATTR_ASSOCIATIVITY => 'left',
        self::ATTR_PRECEDENCE => 0
    ];

    /*
     * Add in the 'standard' operators with the 'standard'
     * precedance.
     * These can then be added to / redefined bu calling ::setOperator()
     */

    public function __construct()
    {
        $this->setOperator('+', [], function($i, $j) {
                return $i + $j;
            })
            ->setOperator('-', [], function($i, $j) {
                return $i - $j;
            })
            ->setOperator('*', [], function($i, $j) {
                return $i * $j;
            })
            ->setOperator('%', [], function($i, $j) {
                return $i % $j;
            })
            ->setOperator('/', [], function($i, $j) {
                return $i / $j;
            })
            ->setOperator('^', [], function($i, $j) {
                return $i ** $j;
            });
        // nck($this->operators);
    }
    /*
     * 
     */

    public function setOperator(string $operator, array $options = [], callable $callback = null)
    {
        $oldOptions = $this->operators[$operator] ?? [];
        $newOptions = array_merge($this->operatorDefaults, $oldOptions, $options);
        if ($callback) {
            $newOptions[self::ATTR_CALLBACK] = $callback;
        };
        $this->operators[$operator] = $newOptions;
        return $this;
    }
    /*
     * 
     */

    public function hasLowerPrecedence($operator1, $operator2): bool
    {
        $op1 = $this->operators[$operator1];
        $op2 = $this->operators[$operator2];
        return
            (
            ('left' === $op1[self::ATTR_ASSOCIATIVITY]) &&
            ($op1[self::ATTR_PRECEDENCE] === $op2[self::ATTR_PRECEDENCE])
            ) ||
            ($op1[self::ATTR_PRECEDENCE] < $op2[self::ATTR_PRECEDENCE]);
    }
    /*
     * 
     */

    public function getOperatorsArray(): array
    {
        return array_keys($this->operators);
    }
    /*
     * 
     */

    public function isOperator($operator = null)
    {
        return $operator && !empty($this->operators[$operator]);
    }
    /*
     * 
     */

    public function calc(string $operator, $val1, $val2)
    {
        if ($this->isOperator($operator)) {
            $cb = $this->operators[$operator][self::ATTR_CALLBACK];
            return $cb($val1, $val2);
        }
    }
}
