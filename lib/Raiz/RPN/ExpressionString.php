<?php
/*
 * 
 */
namespace Raiz\RPN;

class ExpressionString extends Expression
{

    private $formattedString = '';

    /*
     * 
     */

    public function __construct(string $expressionString, array $operators)
    {
        $this->formattedString = $this->formatString($expressionString, array_keys($operators));
        $tokens = $this->formattedString ? \explode(' ', $this->formattedString) : [];
        parent::__construct($tokens, $operators);
    }
    /*
     * 
     */

    public function getFormattedString(): string
    {
        return $this->formattedString;
    }
    /*
     * Correct any formatting in string.
     * Padd brackets & operators, with spaces, then remove contiguous spaces.
     * Too messy to do with preg_replace, 
     * due to escaping of operators, brackets & decimal operands ...
     */

    private function formatString(string $expressionString, array $operators): string
    {
        $searches = $operators;
        $searches[] = '(';
        $searches[] = ')';

        foreach ($searches as $search) {
            $expressionString = \str_replace($search, " {$search} ", $expressionString);
        }
        // strips excess whitespace from the string
        return \trim(\preg_replace('/\s\s+/', ' ', $expressionString));
    }
}
