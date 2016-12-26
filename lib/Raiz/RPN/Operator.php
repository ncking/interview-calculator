<?php
/*
 * 
 */
namespace Raiz\RPN;

class Operator
{

    const ATTR_ASSOCIATIVITY = 'associativity';
    const ATTR_PRECEDENCE = 'precedence';
    const ATTR_CALLBACK = 'callback';

    /*
     * Options []
     */

    private $o = [];
    /*
     * 
     */
    private static $defaults = [
        self::ATTR_ASSOCIATIVITY => 'left',
        self::ATTR_PRECEDENCE => 0
    ];

    /*
     * 
     * 
     */

    public function __construct(string $operator, array $options = [])
    {
        $this->setOptions($options);
    }
    /*
     * 
     */

    public function setOptions(array $options): self
    {
        $this->o = array_merge(self::$defaults, $this->o, $options);
        return $this;
    }
    /*
     * 
     */

    public function hasLowerPrecedence(self $operator): bool
    {
        return
            (
            ('left' === $this->o[self::ATTR_ASSOCIATIVITY]) &&
            ($this->getPrecedence() === $operator->getPrecedence() )
            ) ||
            ($this->getPrecedence() < $operator->getPrecedence());
    }
    /*
     * 
     */

    public function calc(int $val1, int $val2)
    {
        return $this->o[self::ATTR_CALLBACK]($val1, $val2);
    }
    /*
     * 
     */

    public function getPrecedence(): int
    {
        return $this->o[self::ATTR_PRECEDENCE];
    }
}
