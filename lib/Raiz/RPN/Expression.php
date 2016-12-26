<?php
/*
 *
 */
namespace Raiz\RPN;

class Expression
{

    protected $tokens;
    
    protected $operators;

    /*
     *
     */

    public function __construct(array $tokens, array $operators)
    {
        $this->tokens = $tokens;
        $this->operators = $operators;
    }
    /*
     *
     */

    public function toRPN(): array
    {
        $stack = new \SplStack();
        $output = new \SplQueue();

        foreach ($this->tokens as $token) {


            switch (true) {
                /*
                 * If its an operand
                 * add to the output queue
                 */
                case (\is_numeric($token)):
                    $output->enqueue($token);
                    break;
                /*
                 * If its an operator on top of the stack.
                 * The loop through the stack comparing operators
                 */
                case ($opeartor = $this->getOperator($token)):

                    while (
                    ($opeartor2 = $this->getOperatorFromTopOfStack($stack)) && $opeartor->hasLowerPrecedence($opeartor2)
                    ) {
                        $output->enqueue($stack->pop());
                    }
                    $stack->push($token);
                    break;

                case '(' == $token :
                    $stack->push($token);
                    break;

                case ')' == $token:
                    while (count($stack) > 0 && '(' !== $stack->top()) {
                        $output->enqueue($stack->pop());
                    }
                    // remove the bracket
                    $stack->pop();
                    break;

                /*
                 * Unrecoginsed char - not a operand, operator or bracket
                 */
                default:
                    throw new \UnexpectedValueException(sprintf('Unexpected token: %s', $token));
            }
        }

        while ($this->getOperatorFromTopOfStack($stack)) {
            $output->enqueue($stack->pop());
        }

        if (count($stack) > 0) {
            throw new \InvalidArgumentException(sprintf('Mismatched parenthesis or misplaced number in input: %s', json_encode($tokens)));
        }

        return \iterator_to_array($output);
    }
    /*
     *
     */

    public function calculate()
    {
        $stack = [];
        $rpnexp = $this->toRPN();
        
        if (!$rpnexp) {
            return 0;
        }
        
        foreach ($rpnexp as $item) {
            $operator = $this->getOperator($item);
            if ($operator) {
                $val1 = \array_pop($stack);
                $val2 = \array_pop($stack);
                $value = $operator->calc($val2, $val1);
                \array_push($stack, $value);
            } else {
                \array_push($stack, $item);
            }
        }
        return $stack[0];
    }
    /*
     * Is the item at the top of the stack an operator
     */

    private function getOperatorFromTopOfStack(\SplStack $stack)
    {
        if(count($stack) > 0){
            $top = $stack->top();
            return $this->getOperator($top);
        }
    }
    /*
     * 
     */

    private function getOperator(string $key)
    {
        return $this->operators[$key] ?? null;
    }
}
