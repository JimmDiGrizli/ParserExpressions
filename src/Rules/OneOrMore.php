<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\RuleInterface;

/**
 * The one-or-more operators consume one or more consecutive
 * repetitions of their sub-expression e.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
class OneOrMore extends AbstractRule
{

    /**
     * @var \GetSky\ParserExpressions\RuleInterface
     */
    protected $rule;

    /**
     * @param array|string|RuleInterface $rule
     * @param string $name
     */
    public function __construct($rule, $name = "")
    {
        $this->rule = $this->toRule($rule);
        $this->name = (string)$name;
    }

    /**
     * {@inheritdoc}
     */
    public function scan(Context $context)
    {
        $preIndex = $index = $context->getCursor();

        $string = '';
        $result = new Result($this->name);

        while ($value = $this->rule->scan($context)) {
            if ($value instanceof Result) {
                $result->addChild($value);
                $string .= $value->getValue();
                $index = $context->getCursor();
            }
        }

        $context->setCursor($index);

        if ($preIndex != $index) {
            $result->setValue($string, $index);
            return $result;
        }

        return false;
    }
}
