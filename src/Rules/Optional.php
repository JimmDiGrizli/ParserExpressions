<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rule;

/**
 * The optional operators consume zero or one consecutive
 * repetitions of their sub-expression e.
 *
 * @package GetSky\ParserExpressions\Rules
 */
class Optional extends AbstractRule
{

    /**
     * @var \GetSky\ParserExpressions\Rule
     */
    protected $rule;

    /**
     * @param array|string|Rule $rule
     * @param string $name
     */
    public function __construct($rule, $name = "Optional")
    {
        $this->rule = $this->toRule($rule);
        $this->name = (string)$name;
    }

    /**
     * Checks the rules for transmission $context.
     *
     * @param Context $context
     * @return boolean
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();

        $value = $this->rule->scan($context);

        if ($value === false) {
            $context->setCursor($index);
            return true;
        } elseif ($value === true) {
            return true;
        }

        $result = new Result($this->name);
        $result->setValue($value->getValue(), $index);
        $result->addChild($value);

        return $result;
    }
}
